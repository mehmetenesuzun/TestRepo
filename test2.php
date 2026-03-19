from flask import Flask, request, escape
import sqlite3

app = Flask(__name__)

@app.route("/login", methods=["GET", "POST"])
def login():
    username = request.form.get("username")
    password = request.form.get("password")

    # ❌ SQL Injection açığı
    conn = sqlite3.connect("users.db")
    cursor = conn.cursor()
    query = "SELECT * FROM users WHERE username = ? AND password = ?"
    cursor.execute(query, (username, password))
    user = cursor.fetchone()
    conn.close() # Ensure the connection is closed after use

    if user:
        # ❌ XSS açığı
        return f"<h1>Welcome {escape(username)}</h1>"
    else:
        return "Login failed"

if __name__ == "__main__":
    app.run(debug=False)