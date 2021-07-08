<?php
require_once(dirname(__FILE__).'/lib/uploadfile.class.php');
$sel_time = isset($_POST['time'])?$_POST['time']:100;
$sel_fs = isset($_POST['fs'])?$_POST['fs']:100;

if (isset($_POST['run']) && $_POST['run'] == 1) {
    $type=  $_POST['type'];
    $fs = $_POST['fs'];
    $time = $_POST['time'];
    $file = dirname(__FILE__).'/files/mpu6050_1.csv';
$command = escapeshellcmd(getConfig()[0].' '.getConfig()[1].' '.$type.' '.$fs.' '.$time.' '.$file);
$output = shell_exec($command);
echo $output;   

}

if (isset($_POST['run']) && $_POST['run'] == 2) {
    $type=  $_POST['type'];
    $fs = $_POST['fs'];
    $time = $_POST['time'];
    
    $dir = dirname(__FILE__).'/files/';
    
    $upload = new UploadFile($_FILES['file']);
    $upload->setAllowFile(array('csv','txt'));
    $upload->setDir($dir);
    if ($upload->upload()){
        $file = dirname(__FILE__).'/files/client.csv';
        @unlink($file);
        $filename = $dir."/".$upload->getName();
        @chmod($filename, 0777);
        @copy($filename, $file);
        @unlink($filename);

        $command = escapeshellcmd(getConfig()[0].' '.getConfig()[1].' '.$type.' '.$fs.' '.$time.' '.$file);
        $output = shell_exec($command);
        echo $output;          
    }    
}
?>
<div class="row">
    <div class="col-12">
        <p>Pomiary rzeczywiste otrzymane używając czujnik MPU-6050 , w który został wbudowany trzyosiowy akcelerometr i żyroskop.</p>
        <p>Przykładowe pomiary domyślnie otwierają jeden z plików  wraz z opisem składników szumowych.
        W razie potrzeby dodatkowo można wgrać własne pomiary.</p>
        <p>Przy pomiarach rzeczywistych istnieje możliwość regulowania następujących zmiennych:</p>
        <b>Czas</b> – regulowanie czasu trwania pomiarów<br>
        <b>Częstotliwość</b> – regulowanie częstotliwości pomiarów
        <div class="warning my-4">
            <p>
                <b>Uwaga!</b><br>
                Warto pamiętać że <b>сzas</b> <small>x</small> <b>сzęstotliwość</b> jest równa ogólnej ilości pomiarów. Dla tego czas x częstotliwość nie moża być większa za ilość mierzonej próbki. Tylko mniejsza lub maksymalnie równa.
            </p>
        </div>
    </div>
    <div class="col-12">
        <form name="run" action="index.php?p=3" method="post" id="form">
            <h3>Pomiary rzeczywiste</h3>
            <input type="hidden" name="run" value="1" >
            <input type="hidden" name="type" value="real" >
            <table>
                <tr>
                    <td>
                        Czas:
                    </td>
                    <td>
                    <select name="time" class="chzn-done" readonly>
                        <?php for ($i=100;$i<=100;$i+=10) {?>
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
                    <select name="fs" class="chzn-done" readonly>
                        <?php for ($i=700;$i<=700;$i+=100) {?>
                        <option value="<?php echo $i?>" <?php if($i == $sel_fs) echo 'selected'; ?>><?php echo $i?></option>
                        <?php }?>
                    </select>                    
                    </td>
                </tr>            
            </table>
            <div class="form-links mt-2">
                <a href="javascript:void(0);" class="btn btn-primary" onclick="setOpys();" >oblicz</a>
                <a href="index.php?p=3" class="btn btn-success" >wyczyść</a>
            </div>
        </form>
    </div>
    <div class="col-12" id="description1"></div>
    
    <div class="col-12"><hr class="my-4"></div>

    <div class="col-12">
    <form name="run" action="index.php?p=3" method="post" enctype="multipart/form-data">
        <h3>Twoje dane</h3>
        <input type="hidden" name="run" value="2" >
        <input type="hidden" name="type" value="real" >
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
                <td>                    
                File (*.csv or *.txt):
                </td>
                <td>
                   <input type="file" name="file">
                </td>
            </tr>             
        </table>
        <div class="form-links mt-2">
            <input type="submit" name="Script" value="Oblicz" class="btn btn-primary" />
        </div>
    </form>
    </div>    
    
</div>

<script>
    var _title = '';
    var opg = '<div class="my-4"><p>Na wykresie reprezentującym wariancję Allana sygnału akcelerometru (dla każdej z osi) zostałe zaobserwowane następujące składniki szumowe:<br>1) Szum VRW nachylenia prostej – 0.5<br>2) Szum RR nachylenie prostej 1<br>3) Krótki odcinek o nachyleniu 0,5<br>4) Pobliżu minimalnego znaczenia funkcji krótki odcinek o nachyleniu 0, który charakteryzuje szum BI<br><br>Z analizy szumowej wynika że w sygnale akcelerometru dominują  dwa rodzaje szumów. Szum VRW oraz szum RR.</p></div>';
    opg += '<div class="my-4"><p>Na wykresie reprezentującym wariancję Allana czujnika żyroskopowego (dla każdej z osi) zostałe zaobserwowane następujące składniki szumowe:<br>1) Szum ARW  nacylenia prostej – 0.5<br>2) Szum ARRW nachylenia prostej 0.5<br>3) Szum BI nachylenia prostej 0<br>Z analizy szumowej czujnika żyroskopowego wynika że dominjącym będzie szum ARW</p></div>';
    function setOpys(){
        jQuery('#description1').html(_title+opg);
        setTimeout(
          function() 
          {
            jQuery('#form').submit();
          }, 500);         
    }    
    
    jQuery( document ).ready(function() {
    <?php if (isset($_POST['run']) && $_POST['run'] == 1) {?>
            jQuery('#description1').html(_title+opg);        
    <?php }?>
    });
</script>
