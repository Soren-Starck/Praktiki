<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Votre Page</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="assets/javascript/statistiques.js"></script>


<div class="HBox">
    <div id="titleStat" class="title"><span>Statistiques</span></div>
</div>

<div class="VBox">
    <canvas id="dg1"></canvas>
</div>

<div class="VBox">
    <canvas id="dg2"></canvas>
</div>

<div class="VBox">
    <canvas id="dg3"></canvas>
</div>
<div id="jsp">
    <?php echo json_encode($liste); ?>
</div>