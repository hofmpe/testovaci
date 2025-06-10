<?php
function roundup($val){
    return ceil($val);
}

$type = $_POST['typ'] ?? '';
$result = ['obj'=>0,'tloustka'=>0,'obj_nab'=>0];

if($type === 'pult'){
    $s = (float)$_POST['sirka'];
    $d = (float)$_POST['delka'];
    $sklon = (float)$_POST['sklon']/100.0;
    $iz = (float)$_POST['izolace'];
    $s_r = roundup($s);
    $d_r = roundup($d);
    $t = ($iz/1000 + $d*$sklon + $iz/1000)/2;
    $obj = $t * $s * $d;
    $t_r = ($iz/1000 + $d_r*$sklon + $iz/1000)/2;
    $obj_r = $t_r * $s_r * $d_r;
    $result = ['obj'=>$obj,'tloustka'=>$t,'obj_nab'=>$obj_r];
}
elseif($type === 'duopult'){
    $s1 = (float)$_POST['sirka1'];
    $d1 = (float)$_POST['delka1'];
    $s2 = (float)$_POST['sirka2'];
    $d2 = (float)$_POST['delka2'];
    $sklon = (float)$_POST['sklon']/100.0;
    $iz = (float)$_POST['izolace'];
    $s1_r = roundup($s1); $d1_r = roundup($d1);
    $s2_r = roundup($s2); $d2_r = roundup($d2);
    $t1 = ($iz/1000 + $d1*$sklon + $iz/1000)/2;
    $obj1 = $t1 * ($s1-$d2) * $d1;
    $t2 = ($iz/1000 + $d2*$sklon + $iz/1000)/2;
    $obj2 = $t2 * ($s2-$d1) * $d2;
    $uz = 2/3*min($d1,$d2)*$sklon*pow(min($d1,$d2),2) + pow(min($d1,$d2),2)*$iz/1000;
    $obdel_s = min($d1,$d2);
    $obdel_d = abs($d1-$d2);
    $t_nad = ($iz/1000 + min($d1,$d2)*$sklon + $obdel_d*$sklon + $iz/1000 + min($d1,$d2)*$sklon)/2;
    $obj_nad = $t_nad * $obdel_s * $obdel_d;
    $obj = $obj1 + $obj2 + $uz + $obj_nad;
    $t_prumer = $obj / ($s1*$d1 + ($s2-$d1)*$d2);
    $t1_r = ($iz/1000 + $d1_r*$sklon + $iz/1000)/2;
    $obj1_r = $t1_r * ($s1_r-$d2_r) * $d1_r;
    $t2_r = ($iz/1000 + $d2_r*$sklon + $iz/1000)/2;
    $obj2_r = $t2_r * ($s2_r-$d1_r) * $d2_r;
    $uz_r = 2/3*min($d1_r,$d2_r)*$sklon*pow(min($d1_r,$d2_r),2) + pow(min($d1_r,$d2_r),2)*$iz/1000;
    $obdel_s_r = min($d1_r,$d2_r);
    $obdel_d_r = abs($d1_r-$d2_r);
    $t_nad_r = ($iz/1000 + min($d1_r,$d2_r)*$sklon + $obdel_d_r*$sklon + $iz/1000 + min($d1_r,$d2_r)*$sklon)/2;
    $obj_nad_r = $t_nad_r * $obdel_s_r * $obdel_d_r;
    $obj_r = $obj1_r + $obj2_r + $uz_r + $obj_nad_r;
    $result = ['obj'=>$obj,'tloustka'=>$t_prumer,'obj_nab'=>$obj_r];
}
elseif($type === 'vtok'){
    $s = (float)$_POST['sirka'];
    $d = (float)$_POST['delka'];
    $vx = (float)$_POST['vx'];
    $vy = (float)$_POST['vy'];
    $sklon = (float)$_POST['sklon']/100.0;
    $iz = (float)$_POST['izolace'];
    // formulas incomplete -> simple estimation
    $s_r = roundup($s); $d_r = roundup($d);
    $height = $s - $vx; // approximate
    $obj = 2/3*($height*$sklon)*$height*$height + 0.5*(sqrt(2*$height*$height)**2)*$iz/1000;
    $t = 0;
    $obj_r = $obj;
    $result = ['obj'=>$obj,'tloustka'=>$t,'obj_nab'=>$obj_r];
}
else{
    die('Neplatný typ');
}

function create_pdf($data){
    $text = "Objem výpočtový: {$data['obj']} m3\nPrůměrná tloušťka: {$data['tloustka']} m\nObjem nabídkový: {$data['obj_nab']} m3";
    $content = "%PDF-1.3\n1 0 obj\n<< /Type /Catalog /Pages 2 0 R >>\nendobj\n2 0 obj\n<< /Type /Pages /Kids [3 0 R] /Count 1 >>\nendobj\n3 0 obj\n<< /Type /Page /Parent 2 0 R /MediaBox [0 0 300 200] /Contents 4 0 R >>\nendobj\n4 0 obj\n<< /Length ".strlen($text)." >>\nstream\nBT /F1 12 Tf 10 180 Td (".$text.") Tj ET\nendstream\nendobj\n5 0 obj\n<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>\nendobj\nxref\n0 6\n0000000000 65535 f\n0000000010 00000 n\n0000000053 00000 n\n0000000100 00000 n\n0000000181 00000 n\n0000000275 00000 n\ntrailer<< /Size 6 /Root 1 0 R >>\nstartxref\n340\n%%EOF";
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="vysledek.pdf"');
    echo $content;
}

if(isset($_POST['pdf'])){
    create_pdf($result);
    exit;
}
?>
<!DOCTYPE html>
<html lang="cs">
<head>
<meta charset="UTF-8">
<title>Výsledek</title>
</head>
<body>
<h1>Výsledek</h1>
<ul>
<li>Objem spádových klínů (výpočtový): <?php echo number_format($result['obj'],3,',',' '); ?> m3</li>
<li>Průměrná tloušťka spádových klínů: <?php echo number_format($result['tloustka'],3,',',' '); ?> m</li>
<li>Objem spádových klínů (nabídkový): <?php echo number_format($result['obj_nab'],3,',',' '); ?> m3</li>
</ul>
<form method="post">
<?php foreach($_POST as $k=>$v){ echo "<input type='hidden' name='".htmlspecialchars($k,ENT_QUOTES)."' value='".htmlspecialchars($v,ENT_QUOTES)."'>\n"; } ?>
<input type="hidden" name="pdf" value="1">
<button type="submit">Uložit PDF</button>
</form>
</body>
</html>
