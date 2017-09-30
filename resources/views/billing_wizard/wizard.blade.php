<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- Head -->
<head>
    <meta name="description" content="data tables" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="../assets/img/favicon.png" type="image/x-icon">

    <!--Basic Styles-->
    <link href="../assets/css/bootstrap.css" rel="stylesheet" />
    <link id="bootstrap-rtl-link" href="" rel="stylesheet" />
    <link href="../assets/css/font-awesome.min.css" rel="stylesheet" />
    <link href="../assets/css/weather-icons.min.css" rel="stylesheet" />

    <!--Fonts-->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300" rel="stylesheet" type="text/css">

    <!--Beyond styles-->

    <link href="../assets/css/demo.min.css" rel="stylesheet"/>
    <link href="../assets/css/beyond.min.css" rel="stylesheet" />
    <link href="../assets/css/typicons.min.css" rel="stylesheet" />
    <link href="../assets/css/animate.min.css" rel="stylesheet" />
    <link id="skin-link" href="" rel="stylesheet" type="text/css" />

    <!--Page Related styles-->
    <link href="../assets/css/dataTables.bootstrap.css" rel="stylesheet" />

    <!--Skin Script: Place this script in head to load scripts for skins and rtl support-->
    <script src="../assets/js/skins.min.js"></script>

    <!--Estilos personalisados -->
    <link href="../assets/css/estilos.css" rel="stylesheet" media="screen">
</head>
<!-- /Head -->

<body>
<style type="text/css">
    input[type=checkbox]{
        opacity:0.8;
        position:relative;
        z-index:0;
        left:0;
    }
</style>
<div class="container">

    <div class="row content_img_header">
        <img src="../assets/img/bg_encabezado_r2.jpg" class="img-responsive" alt="Responsive image">
    </div>

</div>

<div class="container" style="background: #ffffff; padding: 20px">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li class="active">
                    <a data-toggle="tab" href="#nuevaFactura">
                        Nueva Factura
                    </a>
                </li>
                <li class="tab-red">
                    <a data-toggle="tab" href="#historial">
                        Mi Historial
                    </a>
                </li>
            </ul>
            <div class="row tab-content">
                <div id="nuevaFactura" class="tab-pane active">
                    <h2>Cree su factura</h2>
                    <p>Tan sólo siga las instrucciones indicadas<br>
                    </p>
                    <div class="widget-body">
                        <div id="simplewizard" class="wizard" data-target="#simplewizard-steps">
                            <ul class="steps">
                                <li data-target="#simplewizardstep1" class="active"><span class="step">1</span>Su Ticket<span class="chevron"></span></li>
                                <li data-target="#simplewizardstep2"><span class="step">2</span>Su empresa<span class="chevron"></span></li>
                                <li data-target="#simplewizardstep3"><span class="step">3</span>Detalles<span class="chevron"></span></li>
                                <li data-target="#simplewizardstep4"><span class="step">4</span>Descarga<span class="chevron"></span></li>
                            </ul>
                        </div>

                        <div class="step-content" id="simplewizard-steps">
                            <div class="step-pane active" id="simplewizardstep1">
                                <div class="widget-main no-padding">
                                    <br>
                                    <form role="form">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Número de Ticket *</label>
                                            <input  type="text" id="f1Ticket" class="form-control" value="" placeholder="123456789087654321123456">
                                        </div>
                                        <div class="form-group">
                                            <label for="rfc">RFC *</label>
                                            <input id="txtTaxid"  type="text" name="rfc" class="form-control"  value="" placeholder="AAA010101AAA" required>
                                        </div>
                                        <br>
                                    </form>
                                </div>
                            </div>
                            <div class="step-pane" id="simplewizardstep2">
                                <div class="widget-main no-padding">
                                    <br>
                                    <form id="frmStep2" role="form">
                                        <input id="hdnId" type="hidden" name="id" value="">
                                        <h4><strong>Edite sus datos y presione siguiente:</strong></h4>
                                        <hr class="wide">
                                        <div class="form-group">
                                            <label for="tax_reg_name">Razón Social</label>
                                            <input id="txtTax_reg_name" type="text" name="tax_reg_name" class="form-control" placeholder="" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="tax_id">RFC</label>
                                            <input id="txtTax_id" type="text" name="tax_id" class="form-control" placeholder="">
                                        </div>
                                        <div class="form-group">
                                            <label for="address_line_1">Dirección</label>
                                            <input id="txtAddress_line_1" type="text" name="address_line_1" class="form-control" placeholder="" >
                                        </div>
                                        <div class="form-group">
                                            <label for="neighboorhood">Colonia</label>
                                            <input id = "txtNeighbourhood" type="text" name="neighboorhood" class="form-control" placeholder="" >
                                        </div>
                                        <div class="form-group">
                                            <label for="zipcode">Código Postal</label>
                                            <input id="txtZipcode" type="text" name="zipcode" class="form-control" placeholder="" >
                                        </div>
                                        <div class="form-group">
                                            <label for="city">Municipio/Delegación</label>
                                            <input id="txtCity" type="text" name="city" class="form-control" placeholder="">
                                        </div>
                                        <div class="form-group">
                                            <label for="state">Estado</label>
                                            <input id="txtState" type="text" name="state" class="form-control" placeholder="">
                                        </div>
                                        <label for="work_email">Email</label>
                                        <input id="txtWork_email" name="work_email" type="email" class="form-control" placeholder="">
                                        <br>
                                        <div>
                                            <a  href="./billing-wizard" class="btn btn-danger">
                                                 Cancelar
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="step-pane" id="simplewizardstep3">
                                <div class="widget-main no-padding">
                                    <br>
                                    <div class="well invoice-container">
                                        <div class="row">
                                            <div class="col-xs-6">
                                                <h3 class="">
                                                    <i class="fa fa-check"></i>
                                                    Su factura
                                                </h3>
                                            </div>
                                            <div class="col-xs-6 text-right">
                                                <div>
                                                    <span>Factura:</span>
                                                    <span>#ABC123</span>
                                                    <span> | </span>
                                                    <span>Fecha:</span>
                                                    <span>04/04/2014</span>
                                                    <span> | </span>
                                                </div>
                                                <div class="horizontal-space"></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-5">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <h6>Receptor</h6>
                                                    </div>
                                                    <div class="panel-body">
                                                        <ul>
                                                            <li>
                                                                Acme S.A. de C.V.
                                                            </li>
                                                            <li>
                                                                AAA010101AAA
                                                            </li>
                                                            <li>Av. Siempre Viva No 1 </li>
                                                            <li>Col. Centro, CP. 77777</li>
                                                            <li>San Luis Potosí,S.L.P, México</li>
                                                            <li>email@cliente.com</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> <!-- / end client details section -->
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th><h5 class="no-margin-bottom">Cantidad</h5></th>
                                                <th><h5 class="no-margin-bottom">Unidad</h5></th>
                                                <th><h5 class="no-margin-bottom">Descripción</h5></th>
                                                <th><h5 class="no-margin-bottom text-center">Precio Unitario</h5></th>
                                                <th><h5 class="no-margin-bottom text-center">Importe</h5></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>PZA</td>
                                                <td>Producto 1</td>
                                                <td class="text-center">$200.00</td>
                                                <td class="text-center">$200.00</td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>KG</td>
                                                <td>Producto 2</td>
                                                <td class="text-center">$100.00</td>
                                                <td class="text-center">$200.00</td>
                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td>PZA</td>
                                                <td >Producto 3</td>
                                                <td class="text-center">$150.00</td>
                                                <td class="text-center">$600.00</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="invisible bg-snow"></td>
                                                <td class="text-center">Sub Total</td>
                                                <td class="text-center">$1,000.00 </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="invisible bg-snow"></td>
                                                <td class="text-center">IVA</td>
                                                <td class="text-center">$160.00</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="invisible bg-snow"></td>
                                                <td class="text-center"><strong>Total</strong></td>
                                                <td class="text-center "><strong>$1,160.00</strong></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <hr class="wide"/>
                                        <div class="invoice-notes">
                                            <h5>Notas e Información:</h5>
                                            <p>Observaciones</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="step-pane" id="simplewizardstep4">
                                <div class="widget-main no-padding">
                                    <h4><strong>Se ha generado correctamente su factura</strong></h4>
                                    <hr class="wide">
                                    <br><div class="btn-group btn-group btn-group-justified btn-lg">
                                        <h5>Su factura ha sido enviada al email que nos ha proporcionado</h5></div>

                                    <!--
                                    <div class="btn-group btn-group btn-group-justified btn-lg">
                                        <a href="#" class="btn btn-blue btn-lg">XML y PDF</a>
                                        <a href="#" class="btn btn-warning btn-lg">Sólo XML</a>
                                        <a href="#" class="btn btn-danger btn-lg">Sólo PDF</a>
                                    </div>
                                    -->
                                </div>
                            </div>
                        </div>
                        <div class="actions actions-footer" id="simplewizard-actions">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm btn-prev"> <i class="fa fa-angle-left"></i>Anterior</button>
                                <button type="button" class="btn btn-default btn-sm btn-next" data-last="Finalizar">Siguiente<i class="fa fa-angle-right"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="historial" class="tab-pane">
                    <h2>Revise su historial de facturas</h2>
                    <p>Siga las instrucciones proporcionadas<br>
                    </p>
                    <div class="widget-body">
                        <div id="WiredWizard" class="wizard wizard-wired" data-target="#WiredWizardsteps">
                            <ul class="steps">
                                <li data-target="#wiredstep1" class="active">
                                    <span class="step">1</span>
                                    <span class="title">Su RFC</span>
                                    <span class="chevron"></span>
                                </li>
                                <li data-target="#wiredstep2" class="active">
                                    <span class="step">2</span>
                                    <span class="title">Sus facturas</span>
                                    <span class="chevron"></span>
                                </li>
                            </ul>
                        </div>
                        <div class="step-content" id="WiredWizardsteps">
                            <div class="step-pane active" id="wiredstep1">
                                <div class="widget-main no-padding">
                                    <br>
                                    <form role="form">
                                        <div class="form-group">
                                            <label for="rfc">Ingrese su RFC *</label>
                                            <input type="text" name="rfc" class="form-control"  value="AAA010101AAA">
                                        </div>
                                        <br>
                                        <div>
                                            <a  href="asistenteCliente.html" class="btn btn-danger">
                                                Cancelar
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="step-pane" id="wiredstep2">
                                <div class="widget-main no-padding">
                                    <div role="grid" id="simpledatatable_wrapper" class="dataTables_wrapper form-inline no-footer">
                                        <div id="simpledatatable_filter" class="">
                                            <label>
                                                <select name="simpledatatable_month" aria-controls="simpledatatable" class="form-control">
                                                    <option value="01">Enero</option>
                                                    <option value="02">Febrero</option>
                                                    <option value="03">Marzo</option>
                                                    <option value="04">Abril</option>
                                                    <option value="05">Mayo</option>
                                                    <option value="06">Junio</option>
                                                    <option value="07">Julio</option>
                                                    <option value="08">Agosto</option>
                                                    <option value="09">Septiembre</option>
                                                    <option value="10">Octubre</option>
                                                    <option value="11">Noviembre</option>
                                                    <option value="12">Diciembre</option>
                                                </select>
                                            </label>
                                            <label>
                                                <select name="simpledatatable_year" aria-controls="simpledatatable" class="form-control">
                                                    <option value="2014">2014</option>
                                                    <option value="2013">2013</option>
                                                    <option value="2012">2012</option>
                                                    <option value="2011">2011</option>
                                                    <option value="2010">2010</option>
                                                </select>
                                            </label>
                                        </div>
                                        <div class="dataTables_length" id="simpledatatable_length">
                                            <label>
                                                <select name="simpledatatable_length" aria-controls="simpledatatable" class="form-control input-sm">
                                                    <option value="10">10</option>
                                                    <option value="25">25</option>
                                                    <option value="50">50</option>
                                                    <option value="100">100</option>
                                                </select>
                                            </label>
                                        </div>
                                        <table class="table table-striped table-bordered table-hover dataTable no-footer" id="simpledatatable" aria-describedby="simpledatatable_info">
                                            <thead>
                                            <tr role="row">
                                                <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="" style="width: 24px;">
                                                    <div class="checker"> <span class="">
														  <input type="checkbox" class="group-checkable" data-set="#flip .checkboxes">
														 </span>
                                                    </div>
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="simpledatatable" rowspan="1" colspan="1" aria-label="Folio: activate to sort column ascending" style="width: 126px;">Folio</th>
                                                <th class="sorting" rowspan="1" colspan="1" aria-label="Serie: activate to sort column ascending" style="width: 126px;">Serie</th>
                                                <th class="sorting" tabindex="0" aria-controls="simpledatatable" rowspan="1" colspan="1" aria-label="Fecha/Hora: activate to sort column ascending" style="width: 364px;">Fecha/Hora</th>
                                                <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Total" style="width: 126px;">Total</th>
                                                <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Descargar" style="width: 205px;">Descargar</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr class="odd">
                                                <td class=" ">
                                                    <div class="checker"> <span class="">
															<input type="checkbox" class="checkboxes" value="1">
															  </span>
                                                    </div>
                                                </td>
                                                <td class=" ">1</td>
                                                <td class=" ">A</td>
                                                <td class=" ">2014-09-09T14:08:23</td>
                                                <td class=" ">$100.00</td>
                                                <td class=" ">
                                                    <a href="#" class="btn btn-warning btn-xs">XML</a>
                                                    <a href="#" class="btn btn-danger btn-xs">PDF</a>
                                                </td>
                                            </tr>
                                            <tr class="even">
                                                <td class=" ">
                                                    <div class="checker"> <span class="">
															<input type="checkbox" class="checkboxes" value="1">
															  </span>
                                                    </div>
                                                </td>
                                                <td class=" ">2</td>
                                                <td class=" ">A</td>
                                                <td class=" ">2014-07-09T14:08:23</td>
                                                <td class="center ">$100.00</td>
                                                <td class=" ">
                                                    <a href="#" class="btn btn-warning btn-xs">XML</a>
                                                    <a href="#" class="btn btn-danger btn-xs">PDF</a>
                                                </td>
                                            </tr>
                                            <tr class="odd">
                                                <td class=" ">
                                                    <div class="checker"> <span class="">
															<input type="checkbox" class="checkboxes" value="1">
															  </span>
                                                    </div>
                                                </td>
                                                <td class=" ">3</td>
                                                <td class=" ">A</td>
                                                <td class=" ">2014-09-09T14:08:23</td>
                                                <td class="center ">$100.00</td>
                                                <td class=" ">
                                                    <a href="#" class="btn btn-warning btn-xs">XML</a>
                                                    <a href="#" class="btn btn-danger btn-xs">PDF</a>
                                                </td>
                                            </tr>
                                            <tr class="even">
                                                <td class=" ">
                                                    <div class="checker"> <span class="">
															<input type="checkbox" class="checkboxes" value="1">
															  </span>
                                                    </div>
                                                </td>
                                                <td class=" ">4</td>
                                                <td class=" ">A</td>
                                                <td class=" ">2014-09-09T14:08:23</td>
                                                <td class="center ">$100.00</td>
                                                <td class=" ">
                                                    <a href="#" class="btn btn-warning btn-xs">XML</a>
                                                    <a href="#" class="btn btn-danger btn-xs">PDF</a>
                                                </td>
                                            </tr>
                                            <tr class="odd gradeX">
                                                <td class=" ">
                                                    <div class="checker"> <span class="">
															<input type="checkbox" class="checkboxes" value="1">
															  </span>
                                                    </div>
                                                </td>
                                                <td class=" ">5</td>
                                                <td class=" ">A</td>
                                                <td class=" ">2014-09-09T14:08:23</td>
                                                <td class="center ">$100.00</td>
                                                <td class=" ">
                                                    <a href="#" class="btn btn-warning btn-xs">XML</a>
                                                    <a href="#" class="btn btn-danger btn-xs">PDF</a>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <div class="row DTTTFooter">
                                            <div class="col-sm-6">
                                                <div class="dataTables_info" id="simpledatatable_info" role="alert" aria-live="polite" aria-relevant="all">Mostrando 1 a 5 de 25</div>
                                            </div>
                                            <div class="col-sm-6" style="">
                                                <div class="dataTables_paginate paging_bootstrap" id="simpledatatable_paginate">
                                                    <ul class="pagination" style="min-width:230px">
                                                        <li class="prev disabled"><a href="#"><i class="fa fa-angle-left"></i></a>
                                                        </li>
                                                        <li class="active"><a href="#">1</a>
                                                        </li>
                                                        <li><a href="#">2</a>
                                                        </li>
                                                        <li><a href="#">3</a>
                                                        </li>
                                                        <li><a href="#">4</a>
                                                        </li>
                                                        <li><a href="#">5</a>
                                                        </li>
                                                        <li class="next"><a href="#"><i class="fa fa-angle-right"></i></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <br/>
                                        <div id="simpledatatable_action" class="">
                                            <label>
                                                <a href="#" class="btn btn-sky">Descargar Seleccionados</a>
                                            </label>
                                            <label>
                                                <select name="simpledatatable_type" aria-controls="simpledatatable" class="form-control">
                                                    <option value="Ambos">XML y PDF</option>
                                                    <option value="XML">XML</option>
                                                    <option value="PDF">PDF</option>
                                                </select>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="actions actions-footer" id="WiredWizard-actions">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm btn-prev"> <i class="fa fa-angle-left"></i>Anterior</button>
                                <button type="button" class="btn btn-default btn-sm btn-next" data-last="Finalizar">Siguiente<i class="fa fa-angle-right"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--tabbable-fin-->
            </div>
        </div>
    </div>
</div>
<footer style="width:960px; margin: 0 auto">
    <div class="container">
        <div class="row">
            <div class="col-md-4 ft-col wow fadeInLeft">
                <h4 class="ft-heading">Su Empresa</h4>
                <p>Sistema de autofacturación.</p>
                <p>Aquí podrá facturar sus tickets</p>
            </div>
            <div class="col-md-4 ft-col wow fadeInRight">
                <p><a href="#" >Preguntas Frecuentes</a></p>

                <p><a href="#" >Inicio</a></p>
            </div>
            <div class="col-md-4 ft-col wow fadeInRight">
                &nbsp;
            </div>
            <div class="col-md-4 ft-col wow fadeInRight">
                <h4 class="ft-heading">Soporte</h4>
                <address>
                    <i class="glyphicon glyphicon-earphone"></i> (442)  3400888<br>
                    <i class="glyphicon glyphicon-earphone"></i> 01 800 1234567<br>
                    <i class="glyphicon glyphicon-envelope"></i> <a href="#">jchavez@mitecnologiamexico.com</a><br>
                    <i class="glyphicon glyphicon-globe"></i> <a href="#">mitecnologiamexico.com</a>
                </address>
            </div>

        </div>
    </div>
    <div class="copyright-info">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <p>Copyright &copy; <a href="http://www.oscodo.com/"> Mi Tecnología México  </a> , 2014.</p>
                </div>
                <div class="col-sm-6 leagles"> <a href="#" style="color:#0a75bd"> Política de Privacidad </a> <a href="#" style="color:#0a75bd"> Términos de uso </a> </div>
            </div>
        </div>
    </div>
</footer>



<!--Basic Scripts-->
<script src="../assets/js/jquery-2.0.3.min.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>

<!--Beyond Scripts-->
<script src="../assets/js/beyond.min.js"></script>

<!--Page Related Scripts-->
<script src="../assets/js/datatable/jquery.dataTables.min.js"></script>
<script src="../assets/js/datatable/ZeroClipboard.js"></script>
<script src="../assets/js/datatable/dataTables.tableTools.min.js"></script>
<script src="../assets/js/datatable/dataTables.bootstrap.min.js"></script>
<script src="../assets/js/datatable/datatables-init.js"></script>
<script>
    InitiateSimpleDataTable.init();
    InitiateEditableDataTable.init();
    InitiateExpandableDataTable.init();
    InitiateSearchableDataTable.init();
</script>
<!--Google Analytics::Demo Only-->
<script src="../assets/js/fuelux/wizard/wizard-custom.js"></script>
<script src="../assets/js/toastr/toastr.js"></script>

<script type="text/javascript">
    jQuery(function ($) {
        $('#simplewizard').wizard();
        $('#simplewizard').on('finished', function (e) {
            Notify('Gracias por usar nuestro servicio de facturación.', 'bottom-right', '5000', 'blue', 'fa-check', true);
            //$.delay(2000);
            window.location.href = "{{URL::to('billing-wizard')}}";
        });

        var ajaxquery = true;
        var ajaxquery2 = true;
        var ajaxquery3 = true;        //Creando los eventos dentro del wizard
        $('#simplewizard').on('change', function (evt, data) {
            if(data.step == 1 ){     // step 1 Tax_id (RFC) check;
                //validations
                if(!$("#f1Ticket").val() || !$("#txtTaxid").val()){
                    evt.preventDefault();
                    alert("Es necesario ingresar un ticket y un RFC v'alidos");
                    return false;
                }

                if(ajaxquery){
                    evt.preventDefault();
                    $.ajax({
                        method: "GET",
                        url: "{{URL::to('billing-wizard/customer/taxid')}}" + "/" + $("#txtTaxid").val()
                    })
                        .done(function( response ) {
                            response  = eval("(" + response + ')');

                            if(response.status == "ok"){
                                $("#hdnId").val(response.data.id);
                                $("#txtTax_reg_name").val(response.data.tax_reg_name);
                                $("#txtTax_id").val(response.data.tax_id);
                                $("#txtAddress_line_1").val(response.data.address_line_1);
                                $("#txtNeighbourhood").val(response.data.neighboorhood);
                                $("#txtZipcode").val(response.data.zipcode);
                                $("#txtCity").val(response.data.city);
                                $("#txtState").val(response.data.state);
                                $("#txtWork_email").val(response.data.work_email);
                            }

                            if(response.status == "not_found"){
                                alert("No tenemos registrados sus datos en nuestro sistema, porfavor rellene los datos a continuacion");
                            }
                            ajaxquery = false;
                            $('#simplewizard').wizard('next');
                        });
                }
            }
            else{
                ajaxquery = true;
            }

            if(data.step == 2 && data.direction == 'next'){ // step 2 userdata updating and displaying ticket data
                if(ajaxquery2){
                    evt.preventDefault();
                    $.ajax({
                        method: "GET",
                        url: "{{URL::to('billing-wizard/update')}}",
                        data : $("#frmStep2").serialize()
                    })
                        .done(function( response ) {
                            response  = eval("(" + response + ')');
                            $("#hdnId").val(response.data.id);
                            Notify('Tus datos se actualizaron correctamente.', 'bottom-right', '5000', 'blue', 'fa-check', true);
                            ajaxquery2 = false;
                            $('#simplewizard').wizard('next');
                        });
                }
            }

            if(data.step == 3 && data.direction == 'next'){ // step 3 web service process
                if(ajaxquery3){
                    evt.preventDefault();
                    $.ajax({
                        method: "GET",
                        url: "{{URL::to('billing-wizard/process')}}",
                        data : "profileid=" + $("#hdnId").val()
                    })
                        .done(function( response ) {
                            Notify('Los datos de tu factura se enviaron correctamente.', 'bottom-right', '5000', 'blue', 'fa-check', true);
                            ajaxquery3 = false;
                            $('#simplewizard').wizard('next');
                        });
                }
            }


        });
        //$('#WiredWizard').wizard();
    });


    function mostrardiv(mostrar)
    {
        $("#divRegPartidas").css("display", "none");
        $("#divListadoPartidas").css("display", "none");
        $("#divEditarPartidas").css("display", "none");


        $(mostrar).css("display", "block");
    }
</script>
</body>
</html>