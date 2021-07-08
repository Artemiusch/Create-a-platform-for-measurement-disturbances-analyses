<?php
$arr_color = [''=>'ideal', 'white'=>'white', 'pink'=>'pink', 'brown'=>'brown', 'violet'=>'violet', 'drift'=>'drift'];
$sel_time = isset($_POST['time'])?$_POST['time']:1000;
$sel_fs = isset($_POST['fs'])?$_POST['fs']:100;
$sel_color = isset($_POST['color'])?$_POST['color']:'';
if (isset($_POST['run']) && $_POST['run'] == 1) {
    $type=  $_POST['type'];
    $fs = $_POST['fs'];
    $time = $_POST['time'];
    $color = $_POST['color'];
$command = escapeshellcmd(getConfig()[0].' '.getConfig()[1].' '.$type.' '.$fs.' '.$time.' '.$color);
$output = shell_exec($command);
echo $output;   

}

?>
<div class="row">
    <div class="col-12">
        <p>Pod tytułem „symulacja” zostały określone pojęcia, które charakteryzują idealny ruch czujnika, czyli warunki, dla których na pomiary nie wpływają żadne czynniki zewnętrzne lub wewnętrzne. Wtedy sygnał nie posiada żadnych niepożądanych składników.</p>
        <p>Teoretycznie w stanie nieruchomym sygnał podany od czujnika powinien zostać niezmieniony, czyli musimy na wyjściu dostać linie prostą, a wykres Allana wtedy powinien być pusty. W praktyce wciąż na czujnik oddziaływują różnego rodzaju zakłócenia, dlatego otrzymanie „czystego” sygnału jest niemożliwe.</p>
        <p>W ramach projektu moduł symulacja został stworzony do następujących celów.</p>
        <ul>
            <li>Wygenerować szumy syntetyczne.</li>
            <li>W warunkach idealnych pojedynczo połączyć ich z sygnałem idealnym.</li>
            <li>Porównanie wykresów.</li>
        </ul>
        <p>Przy pomiarach syntetycznych istnieje możliwość regulowania następujących zmiennych:</p>
        <b>Czas</b> – regulowanie czasu trwania pomiarów.<br>
        <b>Częstotliwość</b> – regulowanie częstotliwości pomiarów.<br>
        <b>Kolor</b> – wybór odpowiedniego szumu.<br><br>
        <p>Ogólna liczba wygenerowanych syntetycznie pomiarów - <b>сzas</b> <small>x</small> <b>сzęstotliwość</b>.</p> 
    </div>    
    <div class="col-12">
        <form name="run" action="index.php?p=2" method="post" id="g_form">
            <h3>Żyroskop</h3>
            <input type="hidden" name="run" value="1" >
            <input type="hidden" name="type" value="gyro" >
            <input type="hidden" name="gr" value="1" >
            <table>
                <tr>
                    <td>
                        Czas:
                    </td>
                    <td>
                    <select name="time" class="chzn-done">
                        <?php for ($i=10;$i<=1000;$i+=10) {?>
                        <option value="<?php echo $i?>" <?php if($i == $sel_time) echo 'selected'; ?>><?php echo $i?></option>
                        <?php }?>
                    </select>                    
                    </td>
                </tr>
                <tr>
                    <td>
                        Częstotliwość:
                    </td>
                    <td>
                    <select name="fs" class="chzn-done">
                        <?php for ($i=100;$i<=5000;$i+=100) {?>
                        <option value="<?php echo $i?>" <?php if($i == $sel_fs) echo 'selected'; ?>><?php echo $i?></option>
                        <?php }?>
                    </select>                    
                    </td>
                </tr>
                <tr>
                    <td>
                        Kolor:
                    </td>
                    <td>
                    <select name="color" id="color1" class="chzn-done">
                        <?php foreach ($arr_color as $key=>$c) {?>
                        <option value="<?php echo $key?>" <?php if($key == $sel_color) echo 'selected'; ?>><?php echo $c?></option>
                        <?php }?>
                    </select>                    
                    </td>
                </tr>            
            </table>
            <div class="form-links mt-2">
                <a href="javascript:void(0);" class="btn btn-primary" onclick="setOpysG();" >Oblicz</a>
                <a href="index.php?p=2" class="btn btn-success" >Wyczyść</a>
            </div>
        </form>
    </div>
    <div class="col-12" id="description1"></div>

    <div class="col-12"><hr class="my-4"></div>

    <div class="col-12 mb-4">
        <form name="run" action="index.php?p=2" method="post" id="a_form">
            <h3>Akcelerometr</h3>
            <input type="hidden" name="run" value="1" >
            <input type="hidden" name="type" value="acc" >
            <input type="hidden" name="gr" value="2" >
            <table class="mb-2">
                <tr>
                    <td>
                        Czas:
                    </td>
                    <td>
                    <select name="time" class="chzn-done">
                        <?php for ($i=10;$i<=1000;$i+=10) {?>
                        <option value="<?php echo $i?>" <?php if($i == $sel_time) echo 'selected'; ?>><?php echo $i?></option>
                        <?php }?>
                    </select>                    
                    </td>
                </tr>
                <tr>
                    <td>
                        Częstotliwość:
                    </td>
                    <td>
                    <select name="fs" class="chzn-done">
                        <?php for ($i=100;$i<=5000;$i+=100) {?>
                        <option value="<?php echo $i?>" <?php if($i == $sel_fs) echo 'selected'; ?>><?php echo $i?></option>
                        <?php }?>
                    </select>                    
                    </td>
                </tr>
                <tr>
                    <td>
                        Kolor:
                    </td>
                    <td>
                    <select name="color" id="color2" class="chzn-done">
                        <?php foreach ($arr_color as $key=>$c) {?>
                        <option value="<?php echo $key?>" <?php if($key == $sel_color) echo 'selected'; ?>><?php echo $c?></option>
                        <?php }?>
                    </select>                    
                    </td>
                </tr>              
            </table>
            <div class="form-links mt-2">
                <a href="javascript:void(0);" class="btn btn-primary" onclick="setOpysA();" >Oblicz</a>
                <a href="index.php?p=2" class="btn btn-success" >Wyczyść</a>
            </div>
        </form>
    </div>
    <div class="col-12" id="description2"></div>
</div>

<script>
    var _title = '';
    /* Gyroscope  */
    var opg = [];
    opg[''] = '<div class="my-4"><h3>Ideal Żyroskop</h3><p>Na wykresie został przedstawiony sygnał trzyosiowego czujnika żyroskopowego w warunkach idealnych.  Czujnik znajduje się w pozycji nieruchomej. W tej pozycji  czujnik wysyła pomiary ciągle powtarzające się wartości. Reprezentacja sygnału w idealnych warunkach będzie linia prosta.Przy braku składników szumowych wykres odchylenia Allana będzie pusty.</p></div> ';
    opg['white'] = '<div class="my-4"><h3>White noise</h3><p>Biały szum (ang. White noise) – losowy proces, który opisuje się płaskim widmem oraz równomierną intensywnością po całym paśmie. Biały szum gaussowski – jest szczególnym przypadkiem szumu białego, który został przedstawiony na wykresie. W żyroskopach znany jako szum ARW (ang. Angle Random Walk). Na końcowym wykresie Allana szum biały jest reprezentowany przez nachylenia prostej o współczynniku -1/2.</p><img src="images/ALlan_white_noise_2.png" /></div>';
    opg['pink'] = '<div class="my-4"><h3>Pink noise</h3><p>Szum różowy (ang. Pink noise, flicker noise) – losowy proces w którym widmo jest odwrotnie proporcjonalne do częstotliwości. Ten rodzaj szumu wynika prawie we wszystkich materiałach i elementach stosowanych w elektronicy. Cechą szumu różowego jest spadek częstotliwości w porównaniu do szumu białego W żyroskopach szum różowy znany jako szum BI(ang. Bias Instability). Na końcowym wykresie Allana szum różowy jest reprezentowany przez nachylenia prostej o współczynniku 0.</p><img src="images/Allan_pink_noise_2.png" /></div>' ;
    opg['brown'] = '<div class="my-4"><h3>Red noise</h3><p>Szum czerwony znany jeszcze jako ruch  Browna, proces Wienera (ang red noise, Brownian noise). Charakteryzuje się procesem, w którym widmo jest w zakresie niskich częstotliwości, jeszcze niższych w porównaniu do szumu różowego.. W żyroskopach szum różowy znany jako szum RRW (ang. Rate Ramp Walk).  Na końcowym wykresie Allana szum czerwony jest reprezentowany przez nachylenia prostej o współczynniku 1/2. </p><img src="images/Allan_brown_noise_2.png" /></div>';
    opg['violet'] = '<div class="my-4"><h3>Violet noise</h3><p>Szum fioletowy (ang. violet noise) - charakteryzuje się procesem w którym widmo jest w zakresie wysokich częstotliwości.  Wraz ze wzrostem częstotliwości gęstość widmowa wzrasta. W żyroskopach szum różowy znany jako szum kwantyzacji. (ang. Quantization noise).  Na końcowym wykresie Allana szum czerwony jest reprezentowany przez nachylenia prostej o współczynniku -1. </p><img src="images/Allan_violet_noise_2.png" /></div>';
    opg['drift'] = '<div class="my-4"><h3>Dryft</h3><p>Ten rodzaj szumu pojawia się podczas monotonicznej zmiany sygnału na długim okresie czasowym.  W żyroskopach dryft znany jako szum RR. (ang. rate ramp noise).  Na końcowym wykresie Allana szum czerwony jest reprezentowany przez nachylenia prostej o współczynniku -1. </p><img src="images/Allan_dryft_2.png" /></div>';
    
    function setOpysG(){
        c = jQuery( "#color1" ).val();
        jQuery('#description1').html(_title+opg[c]);
        setTimeout(
          function() 
          {
            jQuery('#g_form').submit();
          }, 500);        
        
    }  
    
    jQuery( document ).ready(function() {
    <?php if (isset($_POST['run']) && $_POST['run'] == 1 && $_POST['gr'] == 1) {?>
            c = jQuery( "#color1" ).val();
            jQuery('#description1').html(_title+opg[c]);     
    <?php }?>
    });    
    
    /* Acselerometr */
    
    var opa = [];
    opa[''] = '<div class="my-4"><h3>Ideal Akcelerometr</h3><p>Na wykresie został przedstawiony sygnał trzyosiowego akcelerometru w warunkach idealnych.  Czujnik znajduje się w pozycji nieruchomej. Akcelerometr  jest bardzo podatny na różne zakłócenia. W pozycji stacjonarnej na oś Z wpływa grawitacja. Z tego powodu ona została zamieszczona. Pozostałe osie są niezmienione. Reprezentacja sygnału w idealnych warunkach będzie linia prosta. Przy braku składników szumowych wykres odchylenia Allana będzie pusty. </p></div>';
    opa['white'] = '<div class="my-4"><h3>White noise</h3><p>Biały szum (ang. White noise)  – losowy proces, który opisuje się płaskim widmem oraz równomierną intensywnością po całym paśmie.  Biały szum gaussowski – jest szczególnym przypadkiem szumu białego, który został przedstawiony na wykresie.  W ekcelerometrach znany jako szum VRW (ang. Velocity Random Walk). Na końcowym wykresie Allana szum biały jest reprezentowany przez nachylenia prostej o współczynniku -1/2. </p><img src="images/ALlan_white_noise_2.png" /></div>';
    opa['pink'] = '<div class="my-4"><h3>Pink noise</h3><p>Szum różowy (ang. Pink noise, flicker noise) – losowy proces w którym widmo jest odwrotnie proporcjonalne do częstotliwości. Ten rodzaj szumu wynika prawie we wszystkich materiałach i elementach stosowanych w elektronicy. Cechą szumu różowego jest spadek częstotliwości w porównaniu do szumu białego W akcelerometrach szum różowy znany jako szum BI (ang. Bias Instability). Na końcowym wykresie Allana szum różowy jest reprezentowany przez nachylenia prostej,o współczynniku 0.</p><img src="images/Allan_pink_noise_2.png" /></div>';
    opa['brown'] = '<div class="my-4"><h3>Red noise</h3><p>Szum czerwony znany jeszcze jako ruch  Browna, proces Wienera (ang red noise, Brownian noise). Charakteryzuje się procesem, w którym widmo jest w zakresie niskich częstotliwości, jeszcze niższych w porównaniu do szumu różowego. W akcelerometrach szum różowy znany jako szum RRW (ang. Rate Ramp Walk).  Na końcowym wykresie Allana szum czerwony jest reprezentowany przez nachylenia prostej o współczynniku 1/2. </p><img src="images/Allan_brown_noise_2.png" /></div>';
    opa['violet'] = '<div class="my-4"><h3>Violet noise</h3><p>Szum fioletowy (ang. violet noise) - charakteryzuje się procesem w którym widmo jest w zakresie wysokich częstotliwości. Wraz ze wzrostem częstotliwości gęstość widmowa wzrasta. W akcelerometrach szum  różowy znany jako szum kwantyzacji. (ang. Quantization noise).  Na końcowym wykresie Allana szum czerwony jest reprezentowany przez nachylenia prostej, o współczynniku -1.</p><img src="images/Allan_violet_noise_2.png" /></div>';
    opa['drift'] = '<div class="my-4"><h3>Dryft</h3><p>Ten rodzaj szumu pojawia się podczas monotonicznej zmiany sygnału na długim okresie czasowym.  W akcelerometrach dryft znany jako szum RR. (ang. rate ramp noise).  Na końcowym wykresie Allana szum czerwony jest reprezentowany przez nachylenia prostej,o współczynniku -1.</p><img src="images/Allan_dryft_2.png" /></div>';
    
    function setOpysA(){
        c = jQuery( "#color2" ).val();
        jQuery('#description2').html(_title+opa[c]);
        setTimeout(
          function() 
          {
            jQuery('#a_form').submit();
          }, 500);         
    }
    
    jQuery( document ).ready(function() {
    <?php if (isset($_POST['run']) && $_POST['run'] == 1 && $_POST['gr'] == 2) {?>
            c = jQuery( "#color2" ).val();
            jQuery('#description2').html(_title+opa[c]);     
    <?php }?>
    });    
</script>
