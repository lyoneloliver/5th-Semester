namespace CalculatorApp
{
    partial class Form1
    {
        private System.ComponentModel.IContainer components = null;
        private System.Windows.Forms.Label lblTitle;
        private System.Windows.Forms.TextBox txtDisplay;
        private System.Windows.Forms.Button btn0;
        private System.Windows.Forms.Button btn1;
        private System.Windows.Forms.Button btn2;
        private System.Windows.Forms.Button btn3;
        private System.Windows.Forms.Button btn4;
        private System.Windows.Forms.Button btn5;
        private System.Windows.Forms.Button btn6;
        private System.Windows.Forms.Button btn7;
        private System.Windows.Forms.Button btn8;
        private System.Windows.Forms.Button btn9;
        private System.Windows.Forms.Button btnDivide;
        private System.Windows.Forms.Button btnMultiply;
        private System.Windows.Forms.Button btnMinus;
        private System.Windows.Forms.Button btnPlus;
        private System.Windows.Forms.Button btnDecimal;
        private System.Windows.Forms.Button btnClear;
        private System.Windows.Forms.Button btnEquals;

        protected override void Dispose(bool disposing)
        {
            if (disposing && (components != null))
            {
                components.Dispose();
            }
            base.Dispose(disposing);
        }

        private void InitializeComponent()
        {
            this.lblTitle = new System.Windows.Forms.Label();
            this.txtDisplay = new System.Windows.Forms.TextBox();
            this.btn7 = new System.Windows.Forms.Button();
            this.btn8 = new System.Windows.Forms.Button();
            this.btn9 = new System.Windows.Forms.Button();
            this.btnDivide = new System.Windows.Forms.Button();
            this.btn4 = new System.Windows.Forms.Button();
            this.btn5 = new System.Windows.Forms.Button();
            this.btn6 = new System.Windows.Forms.Button();
            this.btnMultiply = new System.Windows.Forms.Button();
            this.btn1 = new System.Windows.Forms.Button();
            this.btn2 = new System.Windows.Forms.Button();
            this.btn3 = new System.Windows.Forms.Button();
            this.btnMinus = new System.Windows.Forms.Button();
            this.btn0 = new System.Windows.Forms.Button();
            this.btnDecimal = new System.Windows.Forms.Button();
            this.btnClear = new System.Windows.Forms.Button();
            this.btnPlus = new System.Windows.Forms.Button();
            this.btnEquals = new System.Windows.Forms.Button();
            this.SuspendLayout();

            this.lblTitle.AutoSize = true;
            this.lblTitle.Font = new System.Drawing.Font("Segoe UI", 12F, System.Drawing.FontStyle.Bold);
            this.lblTitle.Location = new System.Drawing.Point(12, 9);
            this.lblTitle.Name = "lblTitle";
            this.lblTitle.Size = new System.Drawing.Size(88, 21);
            this.lblTitle.Text = "Calculator";

            this.txtDisplay.Font = new System.Drawing.Font("Segoe UI", 18F);
            this.txtDisplay.Location = new System.Drawing.Point(12, 38);
            this.txtDisplay.Name = "txtDisplay";
            this.txtDisplay.ReadOnly = true;
            this.txtDisplay.Size = new System.Drawing.Size(260, 39);
            this.txtDisplay.Text = "0";
            this.txtDisplay.TextAlign = System.Windows.Forms.HorizontalAlignment.Right;

            this.btn7.Location = new System.Drawing.Point(12, 90);
            this.btn7.Name = "btn7";
            this.btn7.Size = new System.Drawing.Size(60, 45);
            this.btn7.Text = "7";
            this.btn7.Click += new System.EventHandler(this.NumberButton_Click);

            this.btn8.Location = new System.Drawing.Point(78, 90);
            this.btn8.Name = "btn8";
            this.btn8.Size = new System.Drawing.Size(60, 45);
            this.btn8.Text = "8";
            this.btn8.Click += new System.EventHandler(this.NumberButton_Click);

            this.btn9.Location = new System.Drawing.Point(144, 90);
            this.btn9.Name = "btn9";
            this.btn9.Size = new System.Drawing.Size(60, 45);
            this.btn9.Text = "9";
            this.btn9.Click += new System.EventHandler(this.NumberButton_Click);

            this.btnDivide.Location = new System.Drawing.Point(210, 90);
            this.btnDivide.Name = "btnDivide";
            this.btnDivide.Size = new System.Drawing.Size(62, 45);
            this.btnDivide.Text = "÷";
            this.btnDivide.Click += new System.EventHandler(this.OperatorButton_Click);

            this.btn4.Location = new System.Drawing.Point(12, 145);
            this.btn4.Name = "btn4";
            this.btn4.Size = new System.Drawing.Size(60, 45);
            this.btn4.Text = "4";
            this.btn4.Click += new System.EventHandler(this.NumberButton_Click);

            this.btn5.Location = new System.Drawing.Point(78, 145);
            this.btn5.Name = "btn5";
            this.btn5.Size = new System.Drawing.Size(60, 45);
            this.btn5.Text = "5";
            this.btn5.Click += new System.EventHandler(this.NumberButton_Click);

            this.btn6.Location = new System.Drawing.Point(144, 145);
            this.btn6.Name = "btn6";
            this.btn6.Size = new System.Drawing.Size(60, 45);
            this.btn6.Text = "6";
            this.btn6.Click += new System.EventHandler(this.NumberButton_Click);

            this.btnMultiply.Location = new System.Drawing.Point(210, 145);
            this.btnMultiply.Name = "btnMultiply";
            this.btnMultiply.Size = new System.Drawing.Size(62, 45);
            this.btnMultiply.Text = "x";
            this.btnMultiply.Click += new System.EventHandler(this.OperatorButton_Click);

            this.btn1.Location = new System.Drawing.Point(12, 200);
            this.btn1.Name = "btn1";
            this.btn1.Size = new System.Drawing.Size(60, 45);
            this.btn1.Text = "1";
            this.btn1.Click += new System.EventHandler(this.NumberButton_Click);

            this.btn2.Location = new System.Drawing.Point(78, 200);
            this.btn2.Name = "btn2";
            this.btn2.Size = new System.Drawing.Size(60, 45);
            this.btn2.Text = "2";
            this.btn2.Click += new System.EventHandler(this.NumberButton_Click);

            this.btn3.Location = new System.Drawing.Point(144, 200);
            this.btn3.Name = "btn3";
            this.btn3.Size = new System.Drawing.Size(60, 45);
            this.btn3.Text = "3";
            this.btn3.Click += new System.EventHandler(this.NumberButton_Click);

            this.btnMinus.Location = new System.Drawing.Point(210, 200);
            this.btnMinus.Name = "btnMinus";
            this.btnMinus.Size = new System.Drawing.Size(62, 45);
            this.btnMinus.Text = "-";
            this.btnMinus.Click += new System.EventHandler(this.OperatorButton_Click);

            this.btn0.Location = new System.Drawing.Point(12, 255);
            this.btn0.Name = "btn0";
            this.btn0.Size = new System.Drawing.Size(60, 45);
            this.btn0.Text = "0";
            this.btn0.Click += new System.EventHandler(this.NumberButton_Click);

            this.btnDecimal.Location = new System.Drawing.Point(78, 255);
            this.btnDecimal.Name = "btnDecimal";
            this.btnDecimal.Size = new System.Drawing.Size(60, 45);
            this.btnDecimal.Text = ".";
            this.btnDecimal.Click += new System.EventHandler(this.btnDecimal_Click);

            this.btnClear.Location = new System.Drawing.Point(144, 255);
            this.btnClear.Name = "btnClear";
            this.btnClear.Size = new System.Drawing.Size(60, 45);
            this.btnClear.Text = "C";
            this.btnClear.Click += new System.EventHandler(this.btnClear_Click);

            this.btnPlus.Location = new System.Drawing.Point(210, 255);
            this.btnPlus.Name = "btnPlus";
            this.btnPlus.Size = new System.Drawing.Size(62, 45);
            this.btnPlus.Text = "+";
            this.btnPlus.Click += new System.EventHandler(this.OperatorButton_Click);

            this.btnEquals.Location = new System.Drawing.Point(12, 310);
            this.btnEquals.Name = "btnEquals";
            this.btnEquals.Size = new System.Drawing.Size(260, 45);
            this.btnEquals.Text = "=";
            this.btnEquals.Click += new System.EventHandler(this.btnEquals_Click);

            this.ClientSize = new System.Drawing.Size(284, 370);
            this.Controls.Add(this.lblTitle);
            this.Controls.Add(this.txtDisplay);
            this.Controls.Add(this.btn7);
            this.Controls.Add(this.btn8);
            this.Controls.Add(this.btn9);
            this.Controls.Add(this.btnDivide);
            this.Controls.Add(this.btn4);
            this.Controls.Add(this.btn5);
            this.Controls.Add(this.btn6);
            this.Controls.Add(this.btnMultiply);
            this.Controls.Add(this.btn1);
            this.Controls.Add(this.btn2);
            this.Controls.Add(this.btn3);
            this.Controls.Add(this.btnMinus);
            this.Controls.Add(this.btn0);
            this.Controls.Add(this.btnDecimal);
            this.Controls.Add(this.btnClear);
            this.Controls.Add(this.btnPlus);
            this.Controls.Add(this.btnEquals);
            this.FormBorderStyle = System.Windows.Forms.FormBorderStyle.FixedDialog;
            this.MaximizeBox = false;
            this.Name = "Form1";
            this.StartPosition = System.Windows.Forms.FormStartPosition.CenterScreen;
            this.Text = "Calculator App";
            this.ResumeLayout(false);
            this.PerformLayout();
        }
    }
}