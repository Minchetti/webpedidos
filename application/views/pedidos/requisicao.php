<style>
    .wrapper-observacao{
        display: none;
    }
</style>
<div id="page-wrapper">
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <i class="fa fa-shopping-cart" aria-hidden="true"></i> Requisição
                    <p class="text-center" style="font-size: 0.7em;"><small><i class="fa fa-calendar-o" aria-hidden="true"></i><strong> Emissão <?php print($today); ?></strong></small></p>
                </h1>
            </div>
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-lg-12">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#tabFuncionario" aria-controls="funcionario" role="tab" data-toggle="tab"><i class="fa fa-users" aria-hidden="true"></i> Funcionarios</a></li>
                    <li role="presentation"><a href="#tabProdutos" aria-controls="produtos" role="tab" data-toggle="tab"><i class="fa fa-shopping-basket" aria-hidden="true"></i> Produtos</a></li>
                    <li role="presentation"><a href="#tabEntrega" aria-controls="entrega" role="tab" data-toggle="tab"><i class="fa fa-truck" aria-hidden="true"></i> Entrega</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="tabFuncionario">
                        <div class="row">
                            <div class="col-lg-12">
                                <hr class="invisible">
                                <nav class="navbar navbar-default">
                                    <div class="container-fluid">
                                        <!-- Brand and toggle get grouped for better mobile display -->
                                        <div class="navbar-header">
                                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-requisicoes" aria-expanded="false">
                                                <span class="sr-only">Toggle navigation</span>
                                                <span class="icon-bar"></span>
                                                <span class="icon-bar"></span>
                                                <span class="icon-bar"></span>
                                            </button>
                                        </div>

                                        <!-- Collect the nav links, forms, and other content for toggling -->
                                        <div class="collapse navbar-collapse  navbar-main-system" id="navbar-requisicoes">
                                            <ul class="nav navbar-nav">
                                                <li>
                                                    <!-- <a id="sel-funcionarios" href="#" data-toggle="modal" data-target="#lista-funcionarios">
                                                        <i class="fa fa-user" aria-hidden="true"></i>
                                                        Adicionar <span class="sr-only">(current)</span>
                                                    </a> -->
                                                    <button style="padding: 12px 20px" id="sel-funcionarios" data-toggle="modal" data-target="#lista-funcionarios" class="btn btn-danger">
                                                        <i class="fa fa-user" aria-hidden="true"></i> Adicionar
                                                    </button>
                                                </li>

                                                <li>
                                                    <!-- <a id="sel-lote" href="#" data-toggle="modal" data-target="#lista-setor-funcionarios">
                                                        <i class="fa fa-users" aria-hidden="true"></i>
                                                        Adicionar por setor
                                                    </a> -->
                                                    <button style="padding: 12px 20px" id="sel-lote" data-toggle="modal" data-target="#lista-setor-funcionarios" class="btn btn-danger">
                                                        <i class="fa fa-user" aria-hidden="true"></i> Adicionar por Setor
                                                    </button>
                                                </li>

    <?php if($this->session->criatemplate === true) : ?>       
                    
                                                <li>
                                                    <!-- <a id="sel-template" href="#" data-toggle="modal" data-target="#lista-templates">
                                                        <i class="fa fa-clone" aria-hidden="true"></i> Template
                                                    </a> -->
                                                    <button style="padding: 12px 20px" id="sel-template" data-toggle="modal" data-target="#lista-templates" class="btn btn-danger">
                                                        <i class="fa fa-clone" aria-hidden="true"></i> Template
                                                    </button>
                                                </li>
                                                
                                               
                                                  
                    <?php endif; ?>
                                                <!--<li><a id="reutilizar-pedido" href="#"><i class="fa fa-refresh" aria-hidden="true"></i>
    Reutilizar</a></li>-->
                                            </ul>
                                        </div><!-- /.navbar-collapse -->
                                    </div><!-- /.container-fluid -->
                                </nav>
                            </div>
                        </div>

                        <div class="row rowFuncionarios" style="display:none;">
                            <hr class="invisible">
                            <div class="col-lg-12">
                                <div class="table-responsive">
                                    <table class="table table-condensed table-hover"> <!-- table-bordered -->
                                        <thead style="background: rgb(34,34,34); color: rgb(255, 255, 255);">
                                            <tr>
                                                <th colspan="7" class="text-center"><i class="fa fa-eye" aria-hidden="true"></i> Funcionários</th>
                                            </tr>
                                            <tr>
                                                <th class="text-left">Matrícula</th>
                                                <th class="text-left">Nome</th>
                                                <th class="text-left">Setor</th>
                                                <th class="text-left">GHE</th>
                                                <th class="text-center">Local de entrega</th>
                                                <th class="text-center">Turno</th>
                                                <th colspan="2" class="text-center">Ação</th>
                                            </tr>
                                        </thead>
                                        <tbody id="funcionarios-selecionados"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div role="tabpanel" class="tab-pane" id="tabProdutos">
                        <hr class="invisible">
                        <!-- Observação Row -->
                        <div class="row" style="padding-left:30px; align-items:center; display:flex;">
                        
                            <div class="col-lg-2">
                                <!-- <hr> -->
                                <!-- <button id="listar-produtos" class="btn btn-primary"><i class="fa fa-shopping-basket" aria-hidden="true"></i> Adicionar produtos</button> -->
                                
                                <button style="padding: 12px 20px" id="listar-produtos" class="btn btn-danger">
                                    <i class="fa fa-shopping-basket" aria-hidden="true"></i> Adicionar produtos
                                </button>
                            </div>
                            <div class="col-lg-6" style="padding-left:25px;">
                                <form>
                                    <div class="form-group" style="margin-bottom:0;">
                                        <label for="txtObservacao">Observação <small  style="color:rgb(159, 159, 160); font-size: 0.82em;">Caracteres (<span id="txtObservacao-caracter">0</span>/1000)</small></label>
                                        <textarea rows="2" name="observacao" id="txtObservacao" class="form-control" placeholder="Observação" style="resize: none; text-transform: uppercase;" maxlength="1000"></textarea>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!--// Observação Row -->

                        <!-- Grid Produtos -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div id="avisos-add-produtos"></div>
                            </div>
                        </div>
                        <div class="row rowProdutos" style="display:none;">
                            <hr class="invisible">
                            <div class="col-lg-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-condensed table-hover">
                                        <thead style="background: rgb(34,34,34); color: rgb(255, 255, 255);">
                                            <tr>
                                                <th colspan="8" class="text-center"><i class="fa fa-eye" aria-hidden="true"></i> Revisão de produtos</th>
                                            </tr>
                                            <tr>
                                                <th>Código</th>
                                                <th>PartNumber</th>
                                                <th>Produto</th>
                                                <th>CA</th>
                                                <th class="text-center">Unidade</th>
                                                <th class="text-center">Quantidade</th>
                                                <th colspan="2" class="text-center">Ação</th>
                                            </tr>
                                        </thead>
                                        <tbody id="produtos-selecionados"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- Grid Produtos -->

                        <!-- <div class="row">
                            <div class="col-lg-12">
                                <button id="btn-efetuar-solicitacao" class="btn btn-success pull-right"><i class="fa fa-check" aria-hidden="true"></i> Aprovar</button>
                                
                            </div>
                        </div> -->
                    </div>


                    <div role="tabpanel" class="tab-pane" id="tabEntrega"> 
                        <hr class="invisible">                        
                        
                        
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label name="local" for="cbLocalExterno"><i class="fa fa-truck" aria-hidden="true"></i> Local da Entrega</label>
                                    <select class="form-control" id="cbLocalExterno"></select>
                                </div>
                            </div>
                        </div>


                        <!-- CEP-->
                        <div class="row" id="cep" style="display:none;">
                            <form>
                                <div class="col-lg-2" style="padding-right:0 !important;">
                                    <div class="form-group">
                                        <label for="txtCEP"><i class="fa fa-truck" aria-hidden="true"></i> <small>CEP</small></label>
                                        <input type="text" id="txtCEP" class="form-control input-sm" placeholder="Digite o CEP..."/>
                                    </div>
                                </div>
                                <div class="col-lg-1" style="padding-right:0 !important;">    
                                    <div class="form-group">
                                        <label for="txtNum"><i class="fa fa-truck" aria-hidden="true"></i> <small>Nº</small></label>
                                        <input type="text" id="txtNum" class="form-control input-sm" placeholder="" style="" disabled/>
                                    </div>
                                </div>
                                <div class="col-lg-3" style="padding-right:0 !important;">    
                                    <div class="form-group">
                                        <label for="txtRua"><i class="fa fa-truck" aria-hidden="true"></i> <small>Rua</small></label>
                                        <input type="text" id="txtRua" class="form-control input-sm" placeholder="" style="" disabled/>
                                    </div>
                                </div>
                                <div class="col-lg-2" style="padding-right:0 !important;">
                                    <div class="form-group">
                                        <label for="txtBairro"><i class="fa fa-truck" aria-hidden="true"></i> <small>Bairro</small></label>
                                        <input type="text" id="txtBairro" class="form-control input-sm" disabled/>
                                    </div>
                                </div>                    
                                <div class="col-lg-2" style="padding-right:0 !important;">
                                    <div class="form-group">
                                        <label for="txtCidade"><i class="fa fa-truck" aria-hidden="true"></i> <small>Cidade</small></label>
                                        <input type="text" id="txtCidade" class="form-control input-sm" disabled/>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="txtEstado"><i class="fa fa-truck" aria-hidden="true"></i> <small>Estado</small></label>
                                        <input type="text" id="txtEstado" class="form-control input-sm" disabled/>
                                    </div>
                                </div>
                                
                            </form>
                        </div>
                    <!--// CEP-->


                        
                        <div class="row">
                            <div class="col-lg-12">
                                <button id="btn-efetuar-solicitacao" class="btn btn-success pull-right"><i class="fa fa-check" aria-hidden="true"></i> Aprovar</button>                                
                            </div>
                        </div>
                    </div>                    


                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <hr style="border-color:#222;">
                <div class="pull-left">
                    <button id="btn-cancelar-requisicao" style="display:none;" class="btn btn-danger"><i class="fa fa-close" aria-hidden="true"></i> Cancelar</button>
                </div>
            </div>
        </div>
    </div>
<!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->

<!-- Modal selecionar produtos -->
<div id="lista-produtos" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Lista de produtos">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-list" aria-hidden="true"></i> Lista de produtosSs</h4>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-lg-12">
                    <form class="form-inline">
                        <div class="form-group">
                            <label class="sr-only" for="txtProduto">Produto</label>
                            <input type="text" class="form-control" id="txtProduto" placeholder="Produto">
                        </div>
                        <button id="btn-buscarProduto" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Buscar</button>
                    </form>
                </div>
                <hr class="invisible">
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-bordered table-condensed table-hover">
                        <thead style="background: rgb(34,34,34); color: rgb(255, 255, 255);">
                            <tr>
                                <th>Código</th>
                                <th>Partnumber</th>
                                <th>Produto</th>
                                <th>CA</th>
                                <th class="text-center">Unidade</th>
                                <th class="text-center">QTD</th>
                                <th class="text-center">Adicionar</th>
                            </tr>
                        </thead>
                        <tbody id="selecionar-produtos"></tbody>
                        <tfoot>
                            <tr>
                                <td colspan="6" id="paginacao-produtos"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-default" data-dismiss="modal"><i class="fa fa-close" aria-hidden="true"></i> Fechar</button>
        <!--<button class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i> Salvar</button>-->
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!--// Modal selecionar produtos -->

<!-- Modal selecionar Funcionarios -->
<div id="lista-funcionarios" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Lista de funcionários">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-list" aria-hidden="true"></i> Adicionar Funcionarios</h4>
      </div>
      <div class="modal-body">
            <div class="row">
                <form>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group">
                            <label for="txtFuncionario" class="sr-only">Funcionario</label>
                            <input type="text" name="matricula" id="txtFuncionario" class="form-control" placeholder="Nome ou Matrícula" style="width: 280px;"/>
                        </div>
                    </div>
                </form>
            </div>
            <!-- Row ReadOnly -->
            <div class="row">
                <div class="col-lg-6">
                    <strong><i class="fa fa-user-circle" aria-hidden="true"></i> Nome: </strong> <span id="spNome"></span>
                </div>
                <div class="col-lg-6">
                    <strong><i class="fa fa-building" aria-hidden="true"></i> Setor: </strong> <span id="spSetor"></span>
                </div>
                <hr class="invisible">
            </div>
            <!--// Row ReadOnly -->

           <!-- Local da entrega Row-->
            <div class="row">
                <form>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label name="local" for="cbLocal"><i class="fa fa-truck" aria-hidden="true"></i> Local da Entrega</label>
                            <select class="form-control" id="cbLocal"></select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="cbTurno"><i class="fa fa-clock-o" aria-hidden="true"></i> Turno</label>
                            <select name="turno" class="form-control" id="cbTurno">
                                <option value="1">PRIMEIRO</option>
                                <option value="2">SEGUNDO</option>
                                <option value="3">TERCEIRO</option>
                                <option value="4">ADMINISTRATIVO</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <!--// Local da entrega -->  




           







            <div class="row">
                <div class="col-lg-12">
                    <div id="funcionarios-avisos"></div>
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button id="fecharaddfunc" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close" aria-hidden="true"></i> Fechar</button>

        <!-- voltar o disabled \/ MM -->
        <button id="btnAdicionarFuncionario" class="btn btn-primary" disabled><i class="fa fa-plus" aria-hidden="true"></i> Adicionar</button> 
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!--// Modal selecionar funcionarios -->

<!-- Modal selecionar setor funcionarios -->
<div id="lista-setor-funcionarios" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Buscar setor">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-list" aria-hidden="true"></i> Listar funcionários por setor</h4><br />
        <div class="alert alert-info">
        <small><i class="glyphicon glyphicon-exclamation-sign"></i> Funcionários de setores diferentes não serão adicionados caso haja algum funcionário ou setor já inserido.</small></div>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-xs-4 col-sm-4 col-md-5 col-lg-5">
                <div class="form-group">
                    <label class="sr-only">Setor</label>
                    <input type="text" name="setor" id="txtSetorFuncionario" class="form-control" placeholder="Setor" style="width: 300px;" />
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                <strong><i class="fa fa-users" aria-hidden="true"></i> </strong><span id="spSetorNome"> - </span>
            </div>
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                <strong><i class="fa fa-building" aria-hidden="true"></i> </strong><span id="spSetorFantasia"> - </span>
            </div>
        </div>
        <hr class="invisible">
        <!-- Local da entrega Row-->
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <label>Serão entregues no mesmo local e turno? </label>
                    <label class="radio-inline">
                        <input type="radio" name="verifica-local" id="verifica-local-default" value="true" checked> Sim
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="verifica-local" id="verifica-local-diferente" value="false"> Não
                    </label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div id="aviso-local-setor"></div>
            </div>
        </div>
        <div class="row">
            <form id="frmLocalEntregaSetor" >
                <div class="col-lg-6">
                    <div class="form-group">
                        <label name="local" for="cbLocalSetor"><i class="fa fa-truck" aria-hidden="true"></i> Local da Entrega</label>
                        <select class="form-control" id="cbLocalSetor"></select>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="cbTurnoSetor"><i class="fa fa-clock-o" aria-hidden="true"></i> Turno</label>
                        <select name="turno" class="form-control" id="cbTurnoSetor">
                            <option value="1">PRIMEIRO</option>
                            <option value="2">SEGUNDO</option>
                            <option value="3">TERCEIRO</option>
                            <option value="4">ADMINISTRATIVO</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
        <!--// Local da entrega -->
      </div>
      <div class="modal-footer">
        <button class="btn btn-default" data-dismiss="modal"><i class="fa fa-close" aria-hidden="true"></i> Fechar</button>
        <button id="btn-adicionarSetor" class="btn btn-primary" disabled><i class="fa fa-plus" aria-hidden="true"></i> Adicionar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!--// Modal selecionar setor funcionarios -->

<!-- Modal selecionar local de entrega e turno -->
<div id="selecionar-local-entrega" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Local de entrega e turno">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-list" aria-hidden="true"></i> Defina o local de entrega e o turno</h4>
      </div>
      <div class="modal-body" style="overflow-y: auto; height: 420px;">
            <div id="lista-funcionarios-setor"></div>
      </div>
      <div class="modal-footer">
        <button id="btn-localEntregaSelecionado" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Adicionar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!--// Modal selecionar local de entra e turno -->

<!-- Modal selecionar local de entrega e turno Template -->
<div id="selecionar-local-entrega-todos" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Local de entrega e turno" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-list" aria-hidden="true"></i> Defina o local de entrega e o turno</h4>
      </div>
      <div class="modal-body" style="overflow-y: auto; height: 120px;">
            <div id="lista-local-entrega-todos"></div>
      </div>
      <div class="modal-footer">
        <button id="btn-local-entrega-selecionado-todos" class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i> Confirmar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!--// Modal selecionar local de entra e turno -->


<!-- Modal selecionar local de entrega e turno Template -->
<div id="selecionar-local-entrega-template" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Local de entrega e turno"  data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-list" aria-hidden="true"></i> Defina o local de entrega e o turno</h4>
      </div>
      <div class="modal-body" style="overflow-y: auto; height: 420px;">
            <div id="lista-funcionarios-template"></div>
      </div>
      <div class="modal-footer">
        <button id="btn-local-entrega-template" class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i> Confirmar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!--// Modal selecionar local de entra e turno -->


<!-- Modal Editar quantidade -->
<div id="editar-quantidade-produto" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Editar quantidade">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-list" aria-hidden="true"></i> Editar quantidade</h4>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-lg-4 col-lg-offset-2">
                    <div class="form-group">
                        <label for="txtQuantidadeEdicao">Quantidade</label>
                        <input type="text" name="quantidade-edicao" class="form-control" id="txtQuantidadeEdicao" value="0"/>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <button id="btnConfirmaQty" class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i> Ok </button>
                    </div>
                </div>
            </div>
      </div>
      <div class="modal-footer"></div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!--// Editar quantidade -->

<!-- Modal selecionar template -->
<div id="lista-templates" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Listar templates">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-list" aria-hidden="true"></i> Listar templates</h4>
      </div>
      <div class="modal-body" style="overflow-y: auto; height: 480px;">
            <div class="row">
                <div class="col-lg-2">
                    <div class="form-group">
                        <label for="txtTemplateParam">Nº Template</label>
                        <input type="text" name="template-numero" id="txtTemplateNumero" class="form-control" placeholder="Nº Template" />
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="txtTemplateParam">Descrição</label>
                        <input type="text" name="template-descricao" id="txtTemplateDescricao" class="form-control" placeholder="Descrição" />
                    </div>
                </div>
                <!--<div class="col-lg-3">
                    <div class="form-group">
                        <label for="txtTemplateParam">Setor</label>
                        <input type="text" name="template-setor" id="txtTemplateSetor" class="form-control" placeholder="Setor" />
                    </div>
                </div>-->
                <div class="col-lg-2">
                    <div class="form-group">
                        <label>&nbsp;</label><br /> <!-- GP >.< -->
                        <button id="btn-buscarTemplate" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Buscar</button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-bordered table-condensed table-hover">
                        <thead style="background: rgb(34,34,34); color: rgb(255, 255, 255);">
                            <tr>
                                <th>Número</th>
                                <th>Descrição</th>
                                <th>Setor</th>
                                <th class="text-center">Usuário</th>
                                <th class="text-center">Detalhes</th>
                            </tr>
                        </thead>
                        <tbody id="selecionar-template"></tbody>
                    </table>
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-default" data-dismiss="modal"><i class="fa fa-close" aria-hidden="true"></i> Fechar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!--// Modal selecionar template -->

<!-- Modal Resumo Pedido -->
<div id="resumo-pedido" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Resumo pedido">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-list" aria-hidden="true"></i> Resumo requisição - <span id="resumo-data-emissao"></span> <button id="exportar-pdf" class="btn btn-danger"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>
 Exportar</button></h4>
      </div>
      <div class="modal-body" style="overflow-y: auto; height: 480px;">            
            <div class="row">
                <div class="col-lg-12">
                    <div id="status-abertura-requisicao"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <table id="pdf-resumo-funcionarios" class="table table-bordered table-condensed table-hover">
                        <thead style="background: rgb(34,34,34); color: rgb(255, 255, 255);">
                            <tr>
                                <th>Nº Pedido</th>
                                <th>Matricula</th>
                                <th>Nome</th>
                                <th>Local de entrega</th>
                                <th>Turno</th>
                            </tr>
                        </thead>
                        <tbody id="resumo-pedido-funcionarios"></tbody>
                    </table>
                </div>
            </div>            
            <div class="row">
                <div class="col-lg-12">
                    <div id="alert-observacao" class="alert">
                        <p class="wrapper-observacao">
                            <strong>Observação: </strong>
                        </p>
                        <p class="wrapper-observacao">
                            <span id="resumo-observacao"></span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <table id="pdf-resumo-produtos" class="table table-bordered table-condensed table-hover">
                        <thead style="background: rgb(34,34,34); color: rgb(255, 255, 255);">
                            <tr>
                                <th>-=</th>
                                <th class="text-center">Produtos</th>
                                <th>&nbsp;</th>
                            </tr>
                            <tr>
                                <th>Codigo</th>
                                <th>Descrição</th>
                                <th>Quantidade</th>
                            </tr>
                        </thead>
                        <tbody id="resumo-pedido-produtos"></tbody>
                    </table>
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-default" data-dismiss="modal"><i class="fa fa-close" aria-hidden="true"></i> Fechar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!--// Modal resumo pedido -->



<!-- Modal visualizar produtos -->
<div id="lista-detalhes-template" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Lista de produtos">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-list" aria-hidden="true"></i> Resumo Requisição por Template</h4>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="alert alert-success"><i class="glyphicon glyphicon-thumbs-up"></i> Requisição realizada com sucesso!</div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-bordered table-condensed table-hover">
                        <thead style="background: rgb(34,34,34); color: rgb(255, 255, 255);">
                            <tr>
                                <th>Matricula</th>
                                <th>Nome</th>
                                <th class="text-center">Detalhes</th>
                            </tr>
                        </thead>
                        <tbody id="visualizar-funcionarios"></tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-bordered table-condensed table-hover">
                        <thead style="background: rgb(34,34,34); color: rgb(255, 255, 255);">
                            <tr>
                                <th>Código</th>
                                <th>Produto</th>
                                <th>CA</th>
                                <th class="text-center">Unidade</th>
                                <th class="text-center">QTD</th>
                                <!--<th class="text-center">Adicionar</th>-->
                            </tr>
                        </thead>
                        <tbody id="visualizar-produtos"></tbody>
                    </table>
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <div class="row">
            <div id="deletar-template" class="col-lg-4"></div>
            <div id="atualizar-template" class="col-lg-4"></div>
            <div class="col-lg-4">
                <button id="detalhes-template-fechar" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close" aria-hidden="true"></i> Fechar</button>
            </div>
        </div>
        <!--<button class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i> Salvar</button>-->
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!--// Modal visualizar produtos -->