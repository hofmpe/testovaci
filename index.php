<!DOCTYPE html>
<html lang="cs">
<head>
<meta charset="UTF-8">
<title>Výpočet spádových klínů</title>
<style>
.hidden { display: none; }
form { margin-bottom: 1em; }
</style>
<script>
function showForm() {
    var type = document.getElementById('typ').value;
    document.getElementById('form_pult').style.display = 'none';
    document.getElementById('form_duopult').style.display = 'none';
    document.getElementById('form_vtok').style.display = 'none';
    if(type === 'pult') document.getElementById('form_pult').style.display = 'block';
    if(type === 'duopult') document.getElementById('form_duopult').style.display = 'block';
    if(type === 'vtok') document.getElementById('form_vtok').style.display = 'block';
}
</script>
</head>
<body>
<h1>Výpočet spádových klínů</h1>
<label for="typ">Typ střechy:</label>
<select id="typ" name="typ" onchange="showForm()">
<option value="">-- vyberte --</option>
<option value="pult">Pultová</option>
<option value="duopult">Duopultová</option>
<option value="vtok">S jedním vtokem</option>
</select>

<form id="form_pult" class="hidden" method="post" action="result.php">
<input type="hidden" name="typ" value="pult">
<label>Š: <input type="number" step="0.001" name="sirka" required></label><br>
<label>D: <input type="number" step="0.001" name="delka" required></label><br>
<label>Sklon (%): <input type="number" step="0.1" name="sklon" required></label><br>
<label>Izolace min (mm): <input type="number" step="1" name="izolace" required></label><br>
<button type="submit">Spočítat</button>
</form>

<form id="form_duopult" class="hidden" method="post" action="result.php">
<input type="hidden" name="typ" value="duopult">
<label>Š1: <input type="number" step="0.001" name="sirka1" required></label><br>
<label>D1: <input type="number" step="0.001" name="delka1" required></label><br>
<label>Š2: <input type="number" step="0.001" name="sirka2" required></label><br>
<label>D2: <input type="number" step="0.001" name="delka2" required></label><br>
<label>Sklon (%): <input type="number" step="0.1" name="sklon" required></label><br>
<label>Izolace min (mm): <input type="number" step="1" name="izolace" required></label><br>
<button type="submit">Spočítat</button>
</form>

<form id="form_vtok" class="hidden" method="post" action="result.php">
<input type="hidden" name="typ" value="vtok">
<label>Š: <input type="number" step="0.001" name="sirka" required></label><br>
<label>D: <input type="number" step="0.001" name="delka" required></label><br>
<label>Vx: <input type="number" step="0.001" name="vx" required></label><br>
<label>Vy: <input type="number" step="0.001" name="vy" required></label><br>
<label>Sklon (%): <input type="number" step="0.1" name="sklon" required></label><br>
<label>Izolace min (mm): <input type="number" step="1" name="izolace" required></label><br>
<button type="submit">Spočítat</button>
</form>
</body>
</html>
