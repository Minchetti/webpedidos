<head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>


<div id="page-wrapper">

    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <i class="fa fa-desktop" aria-hidden="true"></i> Painel de avisos e informações </h1>
            </div>
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-lg-6">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-id-card" aria-hidden="true"></i> Informações adicionais</h3>
                    </div>
                    <div class="panel-body">
                        <!-- Adicionar informações dinamicamente -->
                        <div id="informacao-extra" class="alert alert-info">
                            <p>
                                <i class="glyphicon glyphicon-exclamation-sign"></i> Não existem informações adicionais.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="panel panel-info">
                    <div class="panel-heading" style="display:flex; justify-content:space-between; align-items:center;">
                        <h3 class="panel-title"><i class="glyphicon glyphicon-bullhorn"></i> Quadro de avisos do sistema</h3>

                        <?php if($this->session->criaaviso === true) : ?>
                            <button class="btn btn-danger btn-sm" type="button" data-toggle="modal" data-target="#msg-aviso"><i class="fa fa-plus" aria-hidden="true"></i> Criar Aviso</button>
                        <?php endif; ?>


                    </div>
                    <div class="panel-body">
                        <div id="quadro-avisos"></div>
                    </div>
                </div>

            </div>
        </div>



        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-user" aria-hidden="true"></i> Epi's Requisitados</h3>
                    </div>
                    <div class="panel-body" style="padding-left: 0; padding-right: 0;">
                        <div id="curve_chart" style="width: 100%; height: 350px"></div>      
                    </div>
                </div>
            </div>
        </div>

        <!-- /.row -->
        <?php if($this->session->fiscal_empresa === 2) : ?>
        <div class="row">
            <div class="col-lg-6">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-book" aria-hidden="true"></i> Books</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <a href="<?php echo base_url('webpedidos/assets/arquivos/Book_Jundiai.pdf'); ?>" target="_blank">
                                <figure>
                                    <img class="img-responsive img-thumbnail" src="<?php echo base_url('webpedidos/assets/images/arquivos/catalogo_epi.JPG'); ?>" style="width: 40%; height: 40%;" alt="Book Jundiaí" title="Book Jundiaí"/>
                                    <figcaption>Book Jundiaí</figcaption>
                                </figure>
                                    
                                </a>
                            </div>
                            <div class="col-lg-6">
                                <a href="<?php echo base_url('webpedidos/assets/arquivos/Manual_do_Usuario.pdf'); ?>" target="_blank">
                                <figure>
                                    <img class="img-responsive img-thumbnail" src="<?php echo base_url('webpedidos/assets/images/arquivos/manual.JPG'); ?>" style="width: 40%; height: 40%;" alt="Book Jundiaí" title="Book Jundiaí"/>
                                    <figcaption>Manual Usuário</figcaption>
                                </figure>
                                    
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

    </div>
<!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->










<!-- Modal Aviso MMMMMMM-->
<div id="msg-aviso" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-pencil" aria-hidden="true"></i> Mensagem de Aviso</h4>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <small>*Apenas um aviso pode ser enviado por dia!</small>
                    <br/>
                    <label for="txtMessageAviso">Aviso 
                        <small style="color:rgb(159, 159, 160); font-size: 0.82em;">Caracteres (<span id="txtAvisoCaracter">0</span>/2000)</small> 
                    </label>
                    <textarea id="txtMessageAviso" rows="3" class="form-control" style="text-transform: uppercase;" maxlength="2000"></textarea>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-default" data-dismiss="modal"><i class="fa fa-close" aria-hidden="true"></i> Fechar</button>
        <button id="enviar_aviso" class="btn btn-primary" disabled><i class="fa fa-check" aria-hidden="true"></i> Enviar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!--// Modal selecionar produtos -->