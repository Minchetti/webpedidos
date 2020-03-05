<div id="page-wrapper">

    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <i class="fa fa-user-circle" aria-hidden="true"></i> Usuário
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
                        <li class="active"><a href="#" id="frm-user" data-toggle="modal" data-target="#add-user">
                            <i class="fa fa-user-plus" aria-hidden="true"></i> Novo
                            <span class="sr-only">(current)</span></a></li>
                        <li>
                            <a href="#" id="listar-usuarios"><i class="fa fa-list-alt" aria-hidden="true"></i> Listar</a>
                        </li> 
                    </ul>
                    <form class="navbar-form navbar-left">
                        <div class="form-group">
                            <input type="text" id="txtMatUsuario" class="form-control" placeholder="Matrícula ou Usuário">
                        </div>
                        <button type="submit" id="buscar_user" class="btn btn-default" disabled><i class="fa fa-search" aria-hidden="true"></i>Buscar</button>
                    </form>
                </div><!-- /.navbar-collapse -->


                <!-- MM -->
                <div class="row"> 
                    <div class="col-lg-12">
                        <hr class="invisible">
                        <table id="tableusuarios" style="display:none;" class="table table-hover table-bordered table-striped">
                            <thead style="background: rgb(34,34,34); color: rgb(255, 255, 255);">
                                <tr>
                                    <th>Cod</th>
                                    <th>Funcionário</th>
                                    <th>Login</th>
                                    <th>Nível</th>
                                    <th class="text-center">Detalhes</th>
                                <tr>
                            </thead>
                            <tbody id="listar-usuario"></tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="10" id="paginacao-templates"></td>
                                </tr>
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




    <!-- Modal - Add user -->
    <div id="add-user" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-user-plus" aria-hidden="true"></i> Adicionar usuário</h4>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-lg-4">
                                    <label for="txtMatricula">Matrícula</label>
                                    <input type="text" name="matricula" class="form-control" id="txtMatricula" placeholder="Matrícula" disabled/>
                                </div>
                                <div class="col-lg-8">
                                    <label for="txtFuncionario">Funcionário</label>
                                    <input type="text" name="funcionario" class="form-control" id="txtFuncionario" placeholder="Funcionário" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-4">
                                    <label for="txtUsuario">Usuário</label>
                                    <input type="text" name="usuario" class="form-control" id="txtUsuario" placeholder="Usuário" disabled/>
                                </div>
                                <div class="col-lg-8">
                                    <label for="txtEmail">Email</label>
                                    <input type="text" name="email" class="form-control" id="txtEmail" placeholder="Email" disabled/>
                                </div>
                            </div>
                        </div>
                        <hr class="invisible" />
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><i class="fa fa-users" aria-hidden="true"></i>
 Nível de usuário</h3>
                                    </div>
                                    <div class="panel-body">
                                        <!-- <div class="form-group">
                                            <label>
                                                <input type="radio" name="nivel-acesso" class="form-control" id="cbAdministrador" value="1"/>
                                                | Administrador | 
                                            </label>
                                            <label>
                                                <input type="radio" name="nivel-acesso" class="form-control" id="cbIntermediario" value="2"/>
                                                Intermediário |
                                            </label>
                                            <label>
                                                <input type="radio" name="nivel-acesso" class="form-control" id="cbBasico" value="3" checked/>
                                                Básico |
                                            </label>
                                        </div> -->
                                        <div class="form-group">
                                        <label>Nível de permissões</label>
                                            <select id="grupos-de-acesso" name="" class="form-control">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="col-lg-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><i class="fa fa-line-chart" aria-hidden="true"></i>Relatórios</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label>
                                                <input type="checkbox" name="relatorio-consumo" class="form-control" id="relatorio-consumo" />
                                               | Consumo |
                                            </label>
                                            <label>
                                                <input type="checkbox" name="relatorio-aprovacao" class="form-control" id="relatorio-aprovacao" />
                                                Aprovação |
                                            </label>
                                            <label>
                                                <input type="checkbox" name="relatorio-comparacao" class="form-control" id="relatorio-comparacao" />
                                                Comparação |
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" id="close-modal" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i>
 Fecharr</button>
                    <button id="salvar-usuario" class="btn btn-success" disabled><i class="fa fa-check" aria-hidden="true"></i>
 Salvar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->




<!-- CHANGE USER MODAL -->
     <!-- Modal - CHANGE user -->
     <div id="change-user" class="modal fade" tabindex="-1" role="dialog" onchange="verificarEditar()">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-user-plus" aria-hidden="true"></i> Editar usuário</h4>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-lg-4">
                                    <label for="txtMatricula2">Matrícula</label>
                                    <input type="text" name="matricula" class="form-control" id="txtMatricula2" placeholder="Matrícula" disabled/>
                                </div>
                                <div class="col-lg-8">
                                    <label for="txtFuncionario2">Funcionário</label>
                                    <input type="text" name="funcionario" class="form-control" id="txtFuncionario2" placeholder="Funcionário" disabled />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-4">
                                    <label for="txtUsuario2">Usuário</label>
                                    <input type="text" name="usuario" class="form-control" id="txtUsuario2" placeholder="Usuário" onkeyup="verificarEditar()"/>
                                </div>
                                <div class="col-lg-8">
                                    <label for="txtEmail2">Email</label>
                                    <input type="text" name="email" class="form-control" id="txtEmail2" placeholder="Email" disabled/>
                                </div>
                            </div>
                        </div>
                        <hr class="invisible" />
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><i class="fa fa-users" aria-hidden="true"></i>
 Nível de usuário</h3>
                                    </div>
                                    <div class="panel-body">
                                        <!-- <div class="form-group">
                                            <label>
                                                <input type="radio" name="nivel-acesso" class="form-control" id="cbAdministrador" value="1"/>
                                                | Administrador | 
                                            </label>
                                            <label>
                                                <input type="radio" name="nivel-acesso" class="form-control" id="cbIntermediario" value="2"/>
                                                Intermediário |
                                            </label>
                                            <label>
                                                <input type="radio" name="nivel-acesso" class="form-control" id="cbBasico" value="3" checked/>
                                                Básico |
                                            </label>
                                        </div> -->
                                        <div class="form-group">
                <label>Nível de Permissões</label>
                    <select id="grupos-de-acesso2" name="" class="form-control">
                    </select>
                </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="col-lg-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><i class="fa fa-line-chart" aria-hidden="true"></i>Relatórios</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label>
                                                <input type="checkbox" name="relatorio-consumo" class="form-control" id="relatorio-consumo" />
                                               | Consumo |
                                            </label>
                                            <label>
                                                <input type="checkbox" name="relatorio-aprovacao" class="form-control" id="relatorio-aprovacao" />
                                                Aprovação |
                                            </label>
                                            <label>
                                                <input type="checkbox" name="relatorio-comparacao" class="form-control" id="relatorio-comparacao" />
                                                Comparação |
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </form>
                </div>
                <div class="modal-footer" style="display:flex; justify-content:space-between;">
                    <button id="excluir-usuario" class="btn btn-danger"><i class="fa fa-check" aria-hidden="true"></i> Excluir</button>
                    <div>
                        <button class="btn btn-default" id="close-modal" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i >Fecharr</button>
                        <button id="editar-usuario" class="btn btn-success" disabled><i class="fa fa-check" aria-hidden="true"></i> Salvar</button>
                    </div>

                </div>
                <!-- <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i>
 Fechar</button>
                    <button id="editar-usuario" class="btn btn-success" disabled><i class="fa fa-check" aria-hidden="true"></i>
 Editar</button>
                    
                </div> -->
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->