from flask import Flask, render_template, request, make_response, redirect, url_for

app = Flask(__name__)

# Simulation d'une base de données utilisateur
users = {
    "alice": {"password": "oldpassword", "email": "alice@example.com"},
    "bob": {"password": "oldpassword", "email": "bob@example.com"}
}

@app.route("/")
def home():
    return render_template("index.html")

@app.route("/change_password", methods=["POST"])
def change_password():
    username = request.cookies.get("username")
    new_password = request.form.get("new_password")
    if username and new_password:
        users[username]["password"] = new_password
        return f"Mot de passe changé pour {username} : {new_password}"
    return "Erreur : utilisateur non connecté ou mot de passe manquant."

@app.route("/login", methods=["GET", "POST"])
def login():
    if request.method == "POST":
        username = request.form.get("username")
        if username in users:
            resp = make_response(redirect(url_for("home")))
            resp.set_cookie("username", username)
            return resp
    return render_template("login.html")

if __name__ == "__main__":
    app.run(host="0.0.0.0", port=5000, debug=True)
