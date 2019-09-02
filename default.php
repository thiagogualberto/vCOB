<br>
<?php
//foreach( $_SESSION as $index => $data ){
//     echo $index, ' = ', $data."<br>"; 
//}
if (isset($_SESSION['acessar_modulos'])){
    if ( (($_SESSION['acessar_modulos']["L00000120170808160001"]) != "N") && 
         (($_SESSION['acessar_modulos']["L00000120170808160001"]) != "L")){?>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-group fa-4x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <h3>Cadastros</h3>
                        </div>
                    </div>
                </div>
                <a href="index.php?pg=clienteEmpresaCadastra">
                    <div class="panel-footer">
                        <span class="pull-left">Clientes</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    <?php
    }
    if (($_SESSION['acessar_modulos']["L00000120170808160005"]) != "N"){?>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-money fa-4x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <h3>Cobranças</h3>
                        </div>
                    </div>
                </div>
                <a href="index.php?pg=cobrancas">
                    <div class="panel-footer">
                        <span class="pull-left">Cobranças</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    <?php
    }
    if ( (($_SESSION['acessar_modulos']["L00000120170808160006"]) != "N") && 
         (($_SESSION['acessar_modulos']["L00000120170808160006"]) != "L")){?>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-red">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa  fa-book fa-4x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <h3>Relatórios</h3>
                        </div>
                    </div>
                </div>
                <a href="index.php?pg=relatorios">
                    <div class="panel-footer">
                        <span class="pull-left">Relatórios</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    <?php
    }
}?>