<div id="page-wrapper">

    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <i class="fa fa-check" aria-hidden="true"></i> Grupos de Acesso
                </h1>
            </div>
        </div>
        <!-- /.row -->

        <!-- Navbar interno -->
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#inside-navbar" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="inside-navbar">
                    <ul class="nav navbar-nav">
                    
                    <?php if($this->session->criagrupoacesso === true) : ?>                    
                        <li class="active"><a href="#" id="frm-grupoacesso" data-toggle="modal" data-target="#add-grupoacesso">
                            <i class="fa fa-plus" aria-hidden="true"></i> Novo
                            <span class="sr-only">(current)</span></a>
                        </li>
                    <?php endif; ?>
                        <li>
                            <a href="#" id="listar-gruposacesso"><i class="fa fa-list-alt" aria-hidden="true"></i> Listar</a>
                        </li> 
                    </ul>
                </div><!-- /.navbar-collapse -->


                <!-- MM -->
                <div class="row"> 
                    <div class="col-lg-12">
                        <hr class="invisible">
                        <table id="tablegrupoacesso" style="display:none;" class="table table-hover table-bordered table-striped">
                            <thead style="background: rgb(34,34,34); color: rgb(255, 255, 255);">
                                <tr>
                                    <th class="text-center"><small>Nome</small></th>
                                    <th class="text-center"><small>Aprova Pedido</small></th>
                                    <th class="text-center"><small>Relatório Consumo</small></th>
                                    <th class="text-center"><small>Relatório Aprovação</small></th>
                                    <th class="text-center"><small>Cria Template</small></th>
                                    <th class="text-center"><small>Cria Requisição</small></th>
                                    <th class="text-center"><small>Cria Usuário</small></th>
                                    <th class="text-center"><small>Cria Grupo Acesso</small></th>
                                    <th class="text-center"><small>Cria Aviso</small></th>
                                    <th class="text-center"><small>Responde Sugestão</small></th>
                                    
                    <?php if($this->session->criagrupoacesso === true) : ?>  
                                    <th class="text-center"><small>Detalhes</small></th>
                                    
                    <?php endif; ?>
                                <tr>
                            </thead>
                            <tbody id="listar-grupoacesso"></tbody>
                            <tfoot>
                                <!-- <tr>
                                    <td colspan="10" id="paginacao-templates"></td>
                                </tr> -->
                            </tfoot>
                        </table>
                    </div>
                </div>



            </div><!-- /.container-fluid -->
        </nav>
        <!-- // inside-navbar -->
        
    </div>
<!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->

    <!-- Modal - Add GRUPO ACESSO -->
    <div id="add-grupoacesso" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-user-plus" aria-hidden="true"></i> Criar Grupo de Acesso</h4>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-lg-6">
                                    <label for="txtGrupoAcesso">Nome</label>
                                    <input type="text" name="grupoacesso" class="form-control" id="txtGrupoAcesso" placeholder="Nome"/>
                                </div>
                            </div>
                        </div>
                        <hr class="invisible" />
                        <div class="row">
                           
                            <div class="col-lg-4">     
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><i class="fa fa-clone" aria-hidden="true"></i> Pedidos</h3>
                                        </div>
                                        <div class="panel-body">
                                            <div class="form-group" style="display:flex; justify-content:space-around;">
                                                <label style="display:flex; flex-direction:column; align-items:center;">
                                                    <input type="checkbox" name="aprova-pedido" class="form-control" id="aprova-pedido" />
                                                    <small>Aprova</small>
                                                    <small>Pedido</small>
                                                </label>
                                                <label style="display:flex; flex-direction:column; align-items:center;">
                                                    <input type="checkbox" name="cria-template" class="form-control" id="cria-template" />
                                                    <small>Cria</small>
                                                    <small>Template</small>
                                                </label>
                                                <label style="display:flex; flex-direction:column; align-items:center;">
                                                    <input type="checkbox" name="cria-requisicao" class="form-control" id="cria-requisicao" />
                                                    <small>Cria</small>
                                                    <small>Requisição</small>
                                                </label>
                                            </div>
                                        </div>
                                    </div>                         
                                
                            </div>
                            <div class="col-lg-8" style="padding-left: 0px !important; ">
                                <div class="col-lg-4" style="padding-left: 0px !important; padding-right: 0px !important; " >
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><i class="fa fa-user" aria-hidden="true"></i> Usuários</h3>
                                        </div>
                                        <div class="panel-body">
                                            <div class="form-group" style="display:flex; justify-content:space-around;">
                                                <label style="display:flex; flex-direction:column; align-items:center;">
                                                    <input type="checkbox" name="cria-usuario" class="form-control" id="cria-usuario" />
                                                    <small>Cria</small>
                                                    <small>Usuário</small>
                                                </label>
                                                <label style="display:flex; flex-direction:column; align-items:center;">
                                                    <input type="checkbox" name="cria-grupoacesso" class="form-control" id="cria-grupoacesso" />
                                                    <small>Cria Grupo</small> 
                                                    <small>de Acesso</small>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><i class="fa fa-edit" aria-hidden="true"></i> Mensagem</h3>
                                        </div>
                                        <div class="panel-body">
                                            <div class="form-group" style="display:flex; justify-content:space-around;">
                                                <label style="display:flex; flex-direction:column; align-items:center;">
                                                    <input type="checkbox" name="cria-aviso" class="form-control" id="cria-aviso" />
                                                    <small>Cria</small> 
                                                    <small>Aviso</small>
                                                </label>
                                                <label style="display:flex; flex-direction:column; align-items:center;">
                                                    <input type="checkbox" name="responde-sugestao" class="form-control" id="responde-sugestao" />
                                                    <small>Responde</small>
                                                    <small>Sugestão</small>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4" style="padding-right: 0px !important; padding-left: 0px !important;"> 
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><i class="fa fa-line-chart" aria-hidden="true"></i> Relatórios</h3>
                                        </div>
                                        <div class="panel-body">
                                            <div class="form-group" style="display:flex; justify-content:space-around;">
                                                <label>
                                                    <input type="checkbox" name="relatorio-consumo" class="form-control" id="relatorio-consumo" />
                                                    <small>Consumo</small>                                                    
                                                </label>
                                                <label>
                                                    <input type="checkbox" name="relatorio-aprovacao" class="form-control" id="relatorio-aprovacao" />
                                                    <small>Aprovação</small>
                                                </label>
                                                <!-- <label>
                                                    <input type="checkbox" name="relatorio-comparacao" class="form-control" id="relatorio-comparacao" />
                                                    Comparação |
                                                </label> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>                            
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" id="close-modal" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i>
 Fecharr</button>
                    <button id="salvar-grupoacesso" class="btn btn-success" disabled><i class="fa fa-check" aria-hidden="true"></i>
 Salvar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->






 <!-- Modal - CHANGE GRUPO ACESSO -->
 <div id="change-grupoacesso" class="modal fade" tabindex="-1" role="dialog" onchange="verificarEditar();">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-user-plus" aria-hidden="true"></i> Editar Grupo de Acesso</h4>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-lg-6">
                                    <label for="txtGrupoAcesso">Nome</label>
                                    <input type="text" name="grupoacesso" class="form-control" id="txtGrupoAcesso2" onkeyup="verificarEditar();" placeholder="Nome"/>
                                </div>
                            </div>
                        </div>
                        <hr class="invisible" />
                        <div class="row">
                           
                            <div class="col-lg-4">     
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><i class="fa fa-clone" aria-hidden="true"></i> Pedidos</h3>
                                        </div>
                                        <div class="panel-body" >
                                            <div class="form-group" style="display:flex; justify-content:space-around;">
                                                <label style="display:flex; flex-direction:column; align-items:center;">
                                                    <input type="checkbox" name="aprova-pedido" class="form-control" id="aprova-pedido2" />
                                                    <small>Aprova</small>
                                                    <small>Pedido</small>
                                                </label>
                                                <label style="display:flex; flex-direction:column; align-items:center;">
                                                    <input type="checkbox" name="cria-template" class="form-control" id="cria-template2" />
                                                    <small>Cria</small>
                                                    <small>Template</small>
                                                </label>
                                                <label style="display:flex; flex-direction:column; align-items:center;">
                                                    <input type="checkbox" name="cria-requisicao" class="form-control" id="cria-requisicao2" />
                                                    <small>Cria</small>
                                                    <small>Requisição</small>
                                                </label>
                                            </div>
                                        </div>
                                    </div>                         
                                
                            </div>
                            <div class="col-lg-8" style="padding-left: 0px !important; ">
                                <div class="col-lg-4" style="padding-left: 0px !important; padding-right: 0px !important; " >
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><i class="fa fa-user" aria-hidden="true"></i> Usuários</h3>
                                        </div>
                                        <div class="panel-body">
                                            <div class="form-group" style="display:flex; justify-content:space-around;">
                                                <label style="display:flex; flex-direction:column; align-items:center;">
                                                    <input type="checkbox" name="cria-usuario" class="form-control" id="cria-usuario2" />
                                                    <small>Cria</small>
                                                    <small>Usuário</small>
                                                </label>
                                                <label style="display:flex; flex-direction:column; align-items:center;">
                                                    <input type="checkbox" name="cria-grupoacesso" class="form-control" id="cria-grupoacesso2" />
                                                    <small>Cria Grupo</small> 
                                                    <small>de Acesso</small>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><i class="fa fa-edit" aria-hidden="true"></i> Mensagem</h3>
                                        </div>
                                        <div class="panel-body">
                                            <div class="form-group" style="display:flex; justify-content:space-around;">
                                                <label style="display:flex; flex-direction:column; align-items:center;">
                                                    <input type="checkbox" name="cria-aviso" class="form-control" id="cria-aviso2" />
                                                    <small>Cria</small> 
                                                    <small>Aviso</small>
                                                </label>
                                                <label style="display:flex; flex-direction:column; align-items:center;">
                                                    <input type="checkbox" name="responde-sugestao" class="form-control" id="responde-sugestao2" />
                                                    <small>Responde</small>
                                                    <small>Sugestão</small>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4" style="padding-right: 0px !important; padding-left: 0px !important;"> 
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><i class="fa fa-line-chart" aria-hidden="true"></i> Relatórios</h3>
                                        </div>
                                        <div class="panel-body">
                                            <div class="form-group" style="display:flex; justify-content:space-around;">
                                                <label>
                                                    <input type="checkbox" name="relatorio-consumo" class="form-control" id="relatorio-consumo2" />
                                                    <small>Consumo</small>                                                    
                                                </label>
                                                <label>
                                                    <input type="checkbox" name="relatorio-aprovacao" class="form-control" id="relatorio-aprovacao2" />
                                                    <small>Aprovação</small>
                                                </label>
                                                <!-- <label>
                                                    <input type="checkbox" name="relatorio-comparacao" class="form-control" id="relatorio-comparacao" />
                                                    Comparação |
                                                </label> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>                            
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer" style="display:flex; justify-content:space-between;">
                    <button id="excluir-grupoacesso" class="btn btn-danger"><i class="fa fa-check" aria-hidden="true"></i> Excluir</button>
                    <div>
                        <button class="btn btn-default" id="close-modal" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i >Fecharr</button>
                        <button id="editar-grupoacesso" class="btn btn-success" disabled><i class="fa fa-check" aria-hidden="true"></i> Salvar</button>
                    </div>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->