from flask import Flask, request
import sqlite3

app = Flask(__name__)

@app.route("/login", methods=["GET", "POST"])
def login():
    username = request.form.get("username")
    password = request.form.get("password")

    # ❌ SQL Injection açığı
    conn = sqlite3.connect("users.db")
    cursor = conn.cursor()
    query = f"SELECT * FROM users WHERE username = '{username}' AND password = '{password}'"
    cursor.execute(query)
    user = cursor.fetchone()

    if user:
        # ❌ XSS açığı
        return f"<h1>Welcome {username}</h1>"
    else:
        return "Login failed"

if __name__ == "__main__":
    app.run(debug=True)
