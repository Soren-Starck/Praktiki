<?php
use App\SAE\Model\Repository\EntrepriseRepository;
?>

<a href="frontController.php?controller=ExpPro&action=afficherOffre&experiencePro= <?php echo rawurlencode($expPro->getId())?> " style="text-decoration:none" id="offerButton">
    <div class="subContainer small <?php
                                                       $full_path = get_class($expPro);
                                                       $elements = explode('\\', $full_path);
                                                       $last_element = end($elements);
                                                       echo htmlspecialchars($last_element)
                                                       ?>">
        <div class="header">
            <div class="left">
                <p class="bold typeExpPro"><?php
                    $full_path = get_class($expPro);
                    $elements = explode('\\', $full_path);
                    $last_element = end($elements);
                    echo htmlspecialchars($last_element)
                    ?></p>
                <p><?php echo $expPro->getDatePublication();?></p>
            </div>
            <div class="right">
                <p>Du <?php echo htmlspecialchars($expPro->getDateDebut());?></p>
                <p>au <?php echo htmlspecialchars($expPro->getDateFin());?></p>
            </div>
        </div>
        <div class="information">
            <h3><?php echo htmlspecialchars($expPro->getSujet());?></h3>
            <p><?php $entreprise = (new EntrepriseRepository())->get($expPro->getSiret());
                               echo(htmlspecialchars($entreprise->getNom()));
                               ?></p>
            <p><img src="assets/images/map-pin-icon.png" class="mapPin"><label><?php echo htmlspecialchars($expPro->getCodePostal());?></label></p>
        </div>
    </div>
</a>