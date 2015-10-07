<form class="form-inline" action="donations.php" method="GET">
    <div class="form-group">
        <input type="hidden" name="page" value="monthly" /> 
        <label for="startDate">Date de début</label>
        <input type="month" class="form-control datepickers" id="startDate" name="startDate"
               max="<?= date('Y-m'); ?>"
               value="<?php  echo (isset($_GET['startDate'])) ? $_GET['startDate'] : date('Y-m', strtotime('-5month')); ?>">
    </div>
    <div class="form-group">
        <label for="endDate">Date de fin</label>
        <input type="month" class="form-control datepickers" id="endDate" name="endDate"
               max="<?= date('Y-m'); ?>"
               value="<?php  echo (isset($_GET['endDate'])) ? $_GET['endDate'] : date('Y-m'); ?>">
    </div>
    <button type="submit" class="btn btn-default" id="submit-bt">Valider</button>
</form>

