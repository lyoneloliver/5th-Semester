
const canvas = document.getElementById("canvas");
const gl = canvas.getContext("webgl");

const vertexShaderSource = `
    attribute vec2 aPosition;

    void main() {
        gl_Position = vec4(aPosition, 0.0, 1.0);
    }
`;

const fragmentShaderSource = `
    precision mediump float;
    uniform vec4 uColor;

    void main() {
        gl_FragColor = uColor;
    }
`;

function createShader(type, source) {
    const shader = gl.createShader(type);
    gl.shaderSource(shader, source);
    gl.compileShader(shader);
    return shader;
}

const program = gl.createProgram();
gl.attachShader(program, createShader(gl.VERTEX_SHADER, vertexShaderSource));
gl.attachShader(program, createShader(gl.FRAGMENT_SHADER, fragmentShaderSource));
gl.linkProgram(program);
gl.useProgram(program);

const aPosition = gl.getAttribLocation(program, "aPosition");
const uColor = gl.getUniformLocation(program, "uColor");

function rectangle(x1, y1, x2, y2) {
    return [
        x1, y1, x2, y1, x2, y2,
        x1, y1, x2, y2, x1, y2
    ];
}

function drawLetter(vertices, color) {
    const buffer = gl.createBuffer();
    gl.bindBuffer(gl.ARRAY_BUFFER, buffer);
    gl.bufferData(gl.ARRAY_BUFFER, new Float32Array(vertices), gl.STATIC_DRAW);

    gl.enableVertexAttribArray(aPosition);
    gl.vertexAttribPointer(aPosition, 2, gl.FLOAT, false, 0, 0);

    gl.uniform4f(uColor, color[0], color[1], color[2], 1.0);
    gl.drawArrays(gl.TRIANGLES, 0, vertices.length / 2);
}

const L = [
    ...rectangle(-0.85, -0.72, -0.69, 0.72),
    ...rectangle(-0.69, -0.72, -0.43, -0.55)
];

const O = [
    ...rectangle(-0.32, 0.72, 0.16, 0.55),
    ...rectangle(-0.32, -0.72, 0.16, -0.55),
    ...rectangle(-0.32, -0.55, -0.16, 0.55),
    ...rectangle(0.00, -0.55, 0.16, 0.55)
];

const D = [
    ...rectangle(0.27, -0.72, 0.43, 0.72),
    ...rectangle(0.43, 0.72, 0.62, 0.55),
    ...rectangle(0.43, -0.72, 0.62, -0.55),
    ...rectangle(0.62, -0.55, 0.78, 0.55),

    0.43, 0.72,
    0.62, 0.55,
    0.78, 0.55,

    0.43, 0.72,
    0.78, 0.55,
    0.62, 0.72,

    0.43, -0.72,
    0.62, -0.55,
    0.78, -0.55,

    0.43, -0.72,
    0.78, -0.55,
    0.62, -0.72
];

gl.clearColor(1.0, 1.0, 1.0, 1.0);
gl.clear(gl.COLOR_BUFFER_BIT);

drawLetter(L, [1.0, 0.0, 0.0]);
drawLetter(O, [0.0, 0.35, 1.0]);
drawLetter(D, [0.0, 0.7, 0.2]);
