<!DOCTYPE html>
<html>
<head>
    <title>XSS Demo</title>
</head>
<body>

<h2>Mesaj Gönder</h2>

<input type="text" id="input" placeholder="Bir şey yaz">
<button onclick="goster()">Göster</button>

<p id="output"></p>

<script>
function goster() {
    const value = document.getElementById("input").value;

    // ❌ XSS açığı: kullanıcı girdisi direkt HTML'e basılıyor
    document.getElementById("output").innerHTML = value;

    <h1>
}
</script>

</body>
</html>
