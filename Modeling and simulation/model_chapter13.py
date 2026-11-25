"""
Model simulasi - Tugas Kelompok (Kelas D)
Studi kasus Chapter 13, Jerry Banks, Soal 10-14 (hal. 534-536).

Bagian A - Soal 10-13 : Example 1 (satu mesin, kedatangan acak, breakdown).
Bagian B - Soal 14    : Lini 4 press logam (shear -> punch -> form -> bend)
                        dengan buffer, die change, dan scrap 20% saat gagal.

Engine: SimPy (discrete-event simulation).
"""
import json
import os
import random
import statistics as stats
import time

import matplotlib

matplotlib.use("Agg")
import matplotlib.pyplot as plt  # noqa: E402
import simpy  # noqa: E402

BASE = os.path.dirname(os.path.abspath(__file__))
OUT = os.path.join(BASE, "hasil")
os.makedirs(OUT, exist_ok=True)


def draw(rng, spec):
    """spec: ('exp', mean) | ('const', nilai) | ('unif', mean, half_width)"""
    kind = spec[0]
    if kind == "exp":
        return rng.expovariate(1.0 / spec[1])
    if kind == "const":
        return float(spec[1])
    if kind == "unif":
        return rng.uniform(spec[1] - spec[2], spec[1] + spec[2])
    raise ValueError(kind)


def mean(xs):
    xs = list(xs)
    return sum(xs) / len(xs) if xs else float("nan")


# ---------------------------------------------------------------------------
# BAGIAN A - Soal 10-13: satu mesin dengan breakdown (Example 1)
# ---------------------------------------------------------------------------
def run_single(seed, horizon, arr, svc, ttf=None, ttr=None,
               mode="resume", trace_until=None):
    """
    Satu mesin, FIFO, kedatangan & proses sesuai spec.
    ttf/ttr = None -> mesin tidak pernah rusak.
    Jam breakdown berjalan terus (wall-clock), sesuai Example 1.
    mode saat rusak:
      resume  : part dikeluarkan, lanjut proses dari sisa waktu (Example 1)
      restart : proses ulang dari awal (Soal 12) - draw baru jika acak
      scrap   : part dibuang (Soal 13)
    """
    rng = random.Random(seed)
    env = simpy.Environment()
    store = simpy.Store(env)
    st = dict(qlen=0, qint=0.0, last=0.0, down_until=0.0, in_service=False,
              down_total=0.0, nfail=0, trace=[], fails=[])
    server = {}
    parts = []

    def change(delta):
        st["qint"] += st["qlen"] * (env.now - st["last"])
        st["last"] = env.now
        st["qlen"] += delta
        if trace_until is not None and env.now <= trace_until:
            st["trace"].append((round(env.now, 4), st["qlen"]))

    def arrivals():
        while True:
            yield env.timeout(draw(rng, arr))
            change(+1)
            store.put(env.now)

    def breakdown_proc():
        while True:
            yield env.timeout(draw(rng, ttf))
            r = draw(rng, ttr)
            st["nfail"] += 1
            st["fails"].append((round(env.now, 4), round(r, 4)))
            st["down_until"] = env.now + r
            st["down_total"] += min(r, max(0.0, horizon - env.now))
            if st["in_service"]:
                server["p"].interrupt()
            yield env.timeout(r)

    def server_proc():
        while True:
            arr_t = yield store.get()
            change(-1)
            t_start = env.now
            n_down, d_time, scrapped = 0, 0.0, False
            rem = draw(rng, svc)
            if env.now < st["down_until"]:  # mulai saat mesin sedang rusak
                w = st["down_until"] - env.now
                n_down += 1
                d_time += w
                yield env.timeout(w)
            while True:
                st["in_service"] = True
                seg = env.now
                try:
                    yield env.timeout(max(rem, 0.0))
                    st["in_service"] = False
                    break
                except simpy.Interrupt:
                    st["in_service"] = False
                    n_down += 1
                    if mode == "resume":
                        rem = rem - (env.now - seg)
                    elif mode == "restart":
                        rem = draw(rng, svc)
                    elif mode == "scrap":
                        scrapped = True
                    w = st["down_until"] - env.now
                    d_time += w
                    yield env.timeout(w)
                    if scrapped:
                        break
            parts.append(dict(wait=t_start - arr_t, svc_time=env.now - t_start,
                              n_down=n_down, d_time=d_time, scrapped=scrapped))

    horizon = horizon  # noqa: F841 (dipakai di closure)
    if ttf is not None:
        env.process(breakdown_proc())
    server["p"] = env.process(server_proc())
    env.process(arrivals())
    env.run(until=horizon)
    change(0)

    done = [p for p in parts if not p["scrapped"]]
    res = dict(
        avg_queue=st["qint"] / horizon,
        parts_completed=len(done),
        parts_scrapped=len(parts) - len(done),
        pct_down=100.0 * st["down_total"] / horizon,
        nfail=st["nfail"],
    )
    if done:
        tot_nd = sum(p["n_down"] for p in done)
        res["downtimes_per_part"] = mean(p["n_down"] for p in done)
        res["avg_downtime_duration"] = (sum(p["d_time"] for p in done) / tot_nd) if tot_nd else 0.0
        res["downtime_per_part"] = mean(p["d_time"] for p in done)
        res["time_to_complete"] = mean(p["svc_time"] for p in done)
    res["scrap_pct"] = 100.0 * (len(parts) - len(done)) / len(parts) if parts else 0.0
    res["trace"] = st["trace"]
    res["fails"] = st["fails"]
    return res


CASES_EX10 = [
    ("A. Abaikan breakdown", dict(arr=("exp", 10), svc=("exp", 7.5), ttf=None, ttr=None), 5),
    ("B. Waktu proses dinaikkan ke 8.0 (tanpa breakdown)", dict(arr=("exp", 10), svc=("exp", 8.0), ttf=None, ttr=None), 5),
    ("C. Semua acak (perlakuan benar)", dict(arr=("exp", 10), svc=("exp", 7.5), ttf=("exp", 1000), ttr=("exp", 50)), 5),
    ("D. Proses acak, breakdown deterministik", dict(arr=("exp", 10), svc=("exp", 7.5), ttf=("const", 1000), ttr=("const", 50)), 5),
    ("E. Semua deterministik", dict(arr=("const", 10), svc=("const", 7.5), ttf=("const", 1000), ttr=("const", 50)), 1),
    ("F. Kedatangan & proses deterministik, breakdown acak", dict(arr=("const", 10), svc=("const", 7.5), ttf=("exp", 1000), ttr=("exp", 50)), 5),
]

FREQ = {
    "Frekuensi rendah (TTF exp mean 1000, TTR exp mean 50)": (("exp", 1000), ("exp", 50)),
    "Frekuensi tinggi (TTF exp mean 2, TTR exp mean 0.1)": (("exp", 2), ("exp", 0.1)),
}


def part_a(horizon=100_000):
    print("== Bagian A: Soal 10 ==")
    out = {"ex10": []}
    trace_run = None
    for name, kw, n in CASES_EX10:
        runs = [run_single(seed=100 + i, horizon=horizon, trace_until=None if i else 3000, **kw) for i in range(n)]
        if name.startswith("C.") and n > 1:
            trace_run = run_single(seed=100, horizon=horizon, trace_until=3000, **kw)
        qs = [r["avg_queue"] for r in runs]
        row = dict(case=name, reps=n, avg=mean(qs), min=min(qs), max=max(qs), runs=qs)
        out["ex10"].append(row)
        print(f"  {name:55s} avg={row['avg']:.2f} range=({row['min']:.2f}-{row['max']:.2f})")

    # Soal 10b: waktu pemulihan antrean setelah repair (kasus C, seed 100)
    tr = trace_run["trace"]
    fails = [f for f in trace_run["fails"] if f[0] <= 3000]
    rec = []
    for t_fail, r in fails:
        pre = [q for (t, q) in tr if t <= t_fail]
        pre_q = pre[-1] if pre else 0
        end = t_fail + r
        after = [t for (t, q) in tr if t >= end and q <= pre_q]
        rec.append(dict(t_fail=t_fail, repair=r, queue_before=pre_q,
                        recover_after=(after[0] - end) if after else None))
    out["ex10b_recovery"] = rec
    out["ex10b_trace_case_C"] = tr
    out["ex10b_fails"] = fails

    print("== Bagian A: Soal 11 (resume) ==")
    out["ex11"] = []
    for fname, (ttf, ttr) in FREQ.items():
        runs = [run_single(seed=200 + i, horizon=horizon, arr=("exp", 10), svc=("exp", 7.5),
                           ttf=ttf, ttr=ttr, mode="resume") for i in range(5)]
        row = summarize_single(fname, runs)
        out["ex11"].append(row)
        print("  ", fname, {k: round(v, 3) for k, v in row.items() if isinstance(v, float)})

    print("== Bagian A: Soal 12 (restart) ==")
    out["ex12"] = []
    for fname, (ttf, ttr) in FREQ.items():
        runs = [run_single(seed=300 + i, horizon=horizon, arr=("exp", 10), svc=("exp", 7.5),
                           ttf=ttf, ttr=ttr, mode="restart") for i in range(5)]
        row = summarize_single(fname, runs)
        out["ex12"].append(row)
        print("  ", fname, {k: round(v, 3) for k, v in row.items() if isinstance(v, float)})

    print("== Bagian A: Soal 13 (scrap) ==")
    out["ex13"] = []
    for fname, (ttf, ttr) in FREQ.items():
        runs = [run_single(seed=400 + i, horizon=horizon, arr=("exp", 10), svc=("exp", 7.5),
                           ttf=ttf, ttr=ttr, mode="scrap") for i in range(5)]
        row = summarize_single(fname, runs)
        out["ex13"].append(row)
        print("  ", fname, {k: round(v, 3) for k, v in row.items() if isinstance(v, float)})
    return out


def summarize_single(name, runs):
    keys = ["avg_queue", "pct_down", "downtimes_per_part", "avg_downtime_duration",
            "downtime_per_part", "time_to_complete", "scrap_pct", "nfail"]
    row = dict(config=name, reps=len(runs))
    for k in keys:
        vals = [r[k] for r in runs if k in r]
        row[k] = mean(vals) if vals else None
        row[k + "_sd"] = stats.pstdev(vals) if len(vals) > 1 else 0.0
    row["parts_completed"] = mean(r["parts_completed"] for r in runs)
    return row


# ---------------------------------------------------------------------------
# BAGIAN B - Soal 14: lini 4 press logam
# ---------------------------------------------------------------------------
PRESS_NAMES = ["Shear", "Punch", "Form", "Bend"]
PRESS_RATE = [4.5, 5.5, 3.8, 3.2]          # lembar per menit
PRESS_MTTF = [100, 90, 180, 240]            # menit (waktu operasi)
PRESS_MTTR = [8, 10, 9, 20]                 # menit (rata-rata; uniform +-5)
PRESS_DIE_N = [500, 400, 750, 600]          # lembar sebelum die change
DIE_TIME = 25.0
REPAIR_HALF = 5.0
P_SCRAP = 0.20
INF = float("inf")


class Buf:
    def __init__(self, env, cap):
        self.env = env
        self.store = simpy.Store(env, capacity=cap)
        self.level = 0
        self.integ = 0.0
        self.last = 0.0
        self.maxl = 0

    def change(self, d):
        self.integ += self.level * (self.env.now - self.last)
        self.last = self.env.now
        self.level += d
        self.maxl = max(self.maxl, self.level)


def run_line(seed, hours, caps):
    """caps: 3 nilai kapasitas buffer (INF = tak terbatas)."""
    H = hours * 60.0
    rng = random.Random(seed)
    env = simpy.Environment()
    bufs = [Buf(env, c) for c in caps]
    M = [dict(busy=0.0, down=0.0, die=0.0, blocked=0.0, starved=0.0,
              scrap=0, nfail=0, n=0) for _ in range(4)]
    good = [0]

    def machine(i):
        pt = 1.0 / PRESS_RATE[i]
        mttf, mttr, die_n = PRESS_MTTF[i], PRESS_MTTR[i], PRESS_DIE_N[i]
        inp = bufs[i - 1] if i > 0 else None
        out = bufs[i] if i < 3 else None
        m = M[i]
        ttf_left = rng.expovariate(1.0 / mttf)  # jam operasi (hanya saat memproses)
        counter = 0
        while True:
            if inp is not None:
                t0 = env.now
                yield inp.store.get()
                inp.change(-1)
                m["starved"] += env.now - t0
            scrapped = False
            rem = pt
            while True:
                if ttf_left >= rem:
                    yield env.timeout(rem)
                    m["busy"] += rem
                    ttf_left -= rem
                    break
                yield env.timeout(ttf_left)
                m["busy"] += ttf_left
                rem -= ttf_left
                r = rng.uniform(mttr - REPAIR_HALF, mttr + REPAIR_HALF)
                yield env.timeout(r)
                m["down"] += r
                m["nfail"] += 1
                ttf_left = rng.expovariate(1.0 / mttf)
                if rng.random() < P_SCRAP:  # 20% lembar dibuang
                    scrapped = True
                    break
                rem = pt  # 80% diproses ulang dari awal
            m["n"] += 1
            counter += 1
            if scrapped:
                m["scrap"] += 1
            elif out is None:
                good[0] += 1
            else:
                t1 = env.now
                yield out.store.put(1)
                m["blocked"] += env.now - t1
                out.change(+1)
            if counter == die_n:
                yield env.timeout(DIE_TIME)
                m["die"] += DIE_TIME
                counter = 0

    for i in range(4):
        env.process(machine(i))
    env.run(until=H)
    for b in bufs:
        b.change(0)

    res = dict(
        throughput_per_hour=good[0] / hours,
        good_sheets=good[0],
        scrapped=sum(m["scrap"] for m in M),
        buf_avg=[b.integ / H for b in bufs],
        buf_max=[b.maxl for b in bufs],
        machines={},
    )
    for i, name in enumerate(PRESS_NAMES):
        m = M[i]
        res["machines"][name] = {
            "busy_pct": 100 * m["busy"] / H,
            "down_pct": 100 * m["down"] / H,
            "die_pct": 100 * m["die"] / H,
            "blocked_pct": 100 * m["blocked"] / H,
            "starved_pct": 100 * m["starved"] / H,
            "failures": m["nfail"],
        }
    return res


def replicate_line(hours, caps, reps, seed0):
    runs = [run_line(seed0 + i, hours, caps) for i in range(reps)]
    thr = [r["throughput_per_hour"] for r in runs]
    summary = dict(
        caps=[c if c != INF else "inf" for c in caps],
        hours=hours,
        reps=reps,
        throughput_mean=mean(thr),
        throughput_sd=stats.pstdev(thr) if len(thr) > 1 else 0.0,
        scrapped_mean=mean(r["scrapped"] for r in runs),
        buf_avg_mean=[mean(r["buf_avg"][k] for r in runs) for k in range(3)],
        buf_max_mean=[mean(r["buf_max"][k] for r in runs) for k in range(3)],
        machines={},
    )
    for name in PRESS_NAMES:
        summary["machines"][name] = {
            k: mean(r["machines"][name][k] for r in runs)
            for k in ["busy_pct", "down_pct", "die_pct", "blocked_pct", "starved_pct", "failures"]
        }
    return summary


def part_b_a(hours=480, reps=5):
    print("== Bagian B(a): buffer tak terbatas, 480 jam ==")
    s = replicate_line(hours, [INF, INF, INF], reps, seed0=1000)
    print("  throughput/jam:", round(s["throughput_mean"], 2), "buf avg:", [round(x, 2) for x in s["buf_avg_mean"]])
    for k, v in s["machines"].items():
        print("  ", k, {kk: round(vv, 2) for kk, vv in v.items()})
    return s


def recommend_split(buf_avg, total=15):
    """Alokasi buffer proporsional terhadap rata-rata isi buffer (dibulatkan, min 1)."""
    s = sum(buf_avg) or 1.0
    raw = [total * b / s for b in buf_avg]
    alloc = [max(1, int(round(x))) for x in raw]
    while sum(alloc) > total:
        k = alloc.index(max(alloc))
        alloc[k] -= 1
    while sum(alloc) < total:
        k = raw.index(max(raw, key=lambda x: x))
        alloc[k] += 1
        raw[k] = -1
    return alloc


def candidate_splits(rec, total=15):
    """Tiap buffer 3 ukuran kandidat (rec-2, rec, rec+2, min 1); hanya kombinasi berjumlah total."""
    opts = [sorted({max(1, r - 2), r, r + 2}) for r in rec]
    combos = []
    for a in opts[0]:
        for b in opts[1]:
            c = total - a - b
            if c in opts[2]:
                combos.append((a, b, c))
    return combos


def part_b_b(rec, hours=1000, reps=5):
    print("== Bagian B(b): buffer terbatas total 15, 1000 jam ==")
    combos = candidate_splits(rec)
    print("  kandidat:", combos, "->", len(combos), "konfigurasi x", reps, "replikasi")
    results = []
    for c in combos:
        s = replicate_line(hours, list(c), reps, seed0=5000)
        results.append(s)
        print(f"  buf={c} throughput={s['throughput_mean']:.2f}/jam (sd {s['throughput_sd']:.2f}) scrap={s['scrapped_mean']:.1f}")
    best = max(results, key=lambda s: s["throughput_mean"])
    return results, best


# ---------------------------------------------------------------------------
# Grafik
# ---------------------------------------------------------------------------
def plot_all(a, b_a, b_results, best):
    # Grafik 1: queue vs time (Soal 10b) kasus C
    tr = a["ex10b_trace_case_C"]
    ts = [t for t, _ in tr]
    qs = [q for _, q in tr]
    fig, ax = plt.subplots(figsize=(8, 3.6))
    ax.step(ts, qs, where="post", lw=1.0, color="#1f4e79")
    for t, r in a["ex10b_fails"]:
        ax.axvspan(t, t + r, color="#c00000", alpha=0.25)
    ax.set_xlabel("Waktu simulasi (menit)")
    ax.set_ylabel("Jumlah part dalam antrean")
    ax.set_title("Soal 10b - Antrean vs waktu (kasus C); area merah = mesin rusak")
    ax.set_xlim(0, 3000)
    fig.tight_layout()
    fig.savefig(os.path.join(OUT, "fig_ex10b_queue.png"), dpi=160)
    plt.close(fig)

    # Grafik 2: rata-rata antrean per kasus Soal 10
    labels = [r["case"].split(".")[0] for r in a["ex10"]]
    avgs = [r["avg"] for r in a["ex10"]]
    err_lo = [r["avg"] - r["min"] for r in a["ex10"]]
    err_hi = [r["max"] - r["avg"] for r in a["ex10"]]
    fig, ax = plt.subplots(figsize=(7, 3.6))
    ax.bar(labels, avgs, yerr=[err_lo, err_hi], capsize=4, color="#2e75b6")
    ax.set_ylabel("Rata-rata part dalam antrean")
    ax.set_title("Soal 10 - Perbandingan perlakuan downtime (rentang antar replikasi)")
    fig.tight_layout()
    fig.savefig(os.path.join(OUT, "fig_ex10_cases.png"), dpi=160)
    plt.close(fig)

    # Grafik 3: Soal 11-13 - waktu selesai layanan & % down
    names = ["Resume (S11)", "Restart (S12)", "Scrap (S13)"]
    fig, axes = plt.subplots(1, 2, figsize=(9, 3.6))
    width = 0.38
    xs = range(3)
    low = [a["ex11"][0]["time_to_complete"], a["ex12"][0]["time_to_complete"], a["ex13"][0]["time_to_complete"]]
    high = [a["ex11"][1]["time_to_complete"], a["ex12"][1]["time_to_complete"], a["ex13"][1]["time_to_complete"]]
    axes[0].bar([x - width / 2 for x in xs], low, width, label="Frek. rendah")
    axes[0].bar([x + width / 2 for x in xs], high, width, label="Frek. tinggi")
    axes[0].set_xticks(list(xs))
    axes[0].set_xticklabels(names, fontsize=8)
    axes[0].set_title("Rata-rata waktu selesai (menit)", fontsize=10)
    axes[0].legend(fontsize=8)
    lowd = [a["ex11"][0]["downtimes_per_part"], a["ex12"][0]["downtimes_per_part"], a["ex13"][0]["downtimes_per_part"]]
    highd = [a["ex11"][1]["downtimes_per_part"], a["ex12"][1]["downtimes_per_part"], a["ex13"][1]["downtimes_per_part"]]
    axes[1].bar([x - width / 2 for x in xs], lowd, width, label="Frek. rendah")
    axes[1].bar([x + width / 2 for x in xs], highd, width, label="Frek. tinggi")
    axes[1].set_xticks(list(xs))
    axes[1].set_xticklabels(names, fontsize=8)
    axes[1].set_title("Rata-rata jumlah downtime per part", fontsize=10)
    axes[1].legend(fontsize=8)
    fig.tight_layout()
    fig.savefig(os.path.join(OUT, "fig_ex11_13.png"), dpi=160)
    plt.close(fig)

    # Grafik 4: Soal 14(a) - utilisasi per press (stacked)
    def stacked(summary, fname, title):
        mnames = PRESS_NAMES
        keys = [("busy_pct", "Proses"), ("down_pct", "Rusak/repair"), ("die_pct", "Die change"),
                ("blocked_pct", "Blocked"), ("starved_pct", "Starved")]
        colors = ["#2e75b6", "#c00000", "#ffc000", "#7f7f7f", "#d9d9d9"]
        fig, ax = plt.subplots(figsize=(7.5, 3.8))
        bottom = [0.0] * 4
        for (k, lab), col in zip(keys, colors):
            vals = [summary["machines"][n][k] for n in mnames]
            ax.bar(mnames, vals, bottom=bottom, label=lab, color=col)
            bottom = [b + v for b, v in zip(bottom, vals)]
        ax.set_ylabel("% waktu")
        ax.set_ylim(0, 100)
        ax.set_title(title, fontsize=10)
        ax.legend(fontsize=8, ncol=5, loc="upper center", bbox_to_anchor=(0.5, -0.12))
        fig.tight_layout()
        fig.savefig(os.path.join(OUT, fname), dpi=160)
        plt.close(fig)

    stacked(b_a, "fig_ex14a_utilisasi.png", "Soal 14(a) - Buffer tak terbatas, 480 jam")
    stacked(best, "fig_ex14b_utilisasi_terbaik.png", f"Soal 14(b) - Alokasi terbaik {tuple(best['caps'])}")

    # Grafik 5: throughput per alokasi buffer (14b)
    labels = [str(tuple(r["caps"])) for r in b_results]
    vals = [r["throughput_mean"] for r in b_results]
    errs = [r["throughput_sd"] for r in b_results]
    fig, ax = plt.subplots(figsize=(8, 3.8))
    ax.bar(labels, vals, yerr=errs, capsize=3, color="#548235")
    ax.set_ylabel("Produksi baik / jam")
    ax.set_xlabel("Alokasi buffer (buf1, buf2, buf3)")
    ax.set_title("Soal 14(b) - Throughput per alokasi buffer (total 15 lembar)", fontsize=10)
    plt.setp(ax.get_xticklabels(), rotation=25, ha="right", fontsize=8)
    fig.tight_layout()
    fig.savefig(os.path.join(OUT, "fig_ex14b_alokasi.png"), dpi=160)
    plt.close(fig)


def part_b_c(hours=1000, reps=5):
    """Sensitivitas: total kapasitas buffer dibagi rata (decision policy)."""
    print("== Bagian B(c): sensitivitas total buffer (dibagi rata), 1000 jam ==")
    rows = []
    for total in [15, 30, 45, 60]:
        per = total // 3
        s = replicate_line(hours, [per, per, per], reps, seed0=9000)
        s["total"] = total
        rows.append(s)
        print(f"  total={total} ({per},{per},{per}) throughput={s['throughput_mean']:.2f}/jam (sd {s['throughput_sd']:.2f})")
    s = replicate_line(hours, [INF, INF, INF], reps, seed0=9000)
    s["total"] = "inf"
    rows.append(s)
    print(f"  total=inf throughput={s['throughput_mean']:.2f}/jam (sd {s['throughput_sd']:.2f})")
    fig, ax = plt.subplots(figsize=(7, 3.6))
    xs = [str(r["total"]) for r in rows]
    ys = [r["throughput_mean"] for r in rows]
    es = [r["throughput_sd"] for r in rows]
    ax.bar(xs, ys, yerr=es, capsize=4, color="#7030a0")
    ax.set_xlabel("Total kapasitas buffer (lembar)")
    ax.set_ylabel("Produksi baik / jam")
    ax.set_title("Sensitivitas throughput terhadap total buffer", fontsize=10)
    fig.tight_layout()
    fig.savefig(os.path.join(OUT, "fig_ex14_sensitivitas.png"), dpi=160)
    plt.close(fig)
    return rows


if __name__ == "__main__":
    t0 = time.time()
    a = part_a()
    print(f"[waktu bagian A: {time.time() - t0:.1f} s]")
    t1 = time.time()
    b_a = part_b_a()
    rec = recommend_split(b_a["buf_avg_mean"])
    print("  rekomendasi alokasi (proporsional buf avg):", rec)
    b_results, best = part_b_b(rec)
    c_rows = part_b_c()
    print(f"[waktu bagian B: {time.time() - t1:.1f} s]")
    plot_all(a, b_a, b_results, best)

    # Simpan ringkasan (tanpa trace panjang)
    a_out = {k: v for k, v in a.items() if k not in ("ex10b_trace_case_C",)}
    a_out["ex10b_trace_points"] = len(a["ex10b_trace_case_C"])
    payload = dict(bagian_a=a_out, bagian_b_a=b_a, rekomendasi=rec,
                   bagian_b_b=b_results, terbaik=best, bagian_b_c=c_rows)
    with open(os.path.join(OUT, "results.json"), "w", encoding="utf-8") as f:
        json.dump(payload, f, indent=2, ensure_ascii=False, default=str)
    print("Selesai. Hasil di:", OUT)
