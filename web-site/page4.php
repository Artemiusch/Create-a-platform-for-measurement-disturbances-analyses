<?php
    
if (isset($_POST['run']) && $_POST['run'] == 1) {
    setConfig($_POST['rows'] );
}
$rows = getConfig();
?>
<div class="row">
    <div class="col-12">
        <form name="run" action="index.php?p=4" method="post">
            <input type="hidden" name="run" value="1" >
            <table>
                <tr>
                    <td>
                    <p class="mb-1"><b>ścieżka do pliku python.exe</b> <small>(ex.: C:\program\demo\Scripts\python.exe)</small></p>
                        <input class="inputbox large mb-2" style="width: 100%; max-width: 450px;" type="text" name="rows[0]" value="<?php echo $rows[0]?>" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="mb-1"><b>ścieżka do pliku script.py</b> <small>(ex.: C:\program\projects\python\script.py)</small></p>
                        <input class="inputbox large" style="width: 100%; max-width: 450px;" type="text" name="rows[1]" value="<?php echo $rows[1]?>" />
                    </td>
                </tr>          
            </table>
            <div class="form-links mt-2">
                <input type="submit" name="Save" value="Zapisz" class="btn btn-primary" />
            </div>
        </form>
    </div>
        
    <div class="col-12"><hr class="my-4"></div>
</div>
