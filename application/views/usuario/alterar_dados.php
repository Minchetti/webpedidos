<div id="page-wrapper">
    <!--
    <input id="fs" type="hidden" name="fs" value="<?php // ( ! empty($fs_codigo)) ? print($fs_codigo) : 0; ?>" />
    -->

    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <i class="fa fa-id-card" aria-hidden="true"></i> Alterar dados
                </h1>
            </div>
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-lg-6">
               <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-user-circle-o" aria-hidden="true"></i> Informação</h3>
                    </div>
                    <div class="panel-body">
                        <p>
                            <strong>Nome: </strong> <?php ( ! empty($usuario))? print($usuario) : ''; ?>
                        </p>
                        <p>
                            <strong>E-mail: </strong> <?php ( ! empty($email))? print($email) : ''; ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
               <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-lock" aria-hidden="true"></i> Alterar senha</h3>
                    </div>
                    <div class="panel-body">
                        <form>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="txtSenha">Senha</label>
                                        <input id="txtSenha" type="password" name="senha" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="txtSenhaConfirmar">Confirmar senha</label>
                                        <input id="txtSenhaConfirmar" type="password" name="confirmar-senha" class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div id="avisos-alterar-dados"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <button id="btn-alterar-senha" class="btn btn-primary pull-right" disabled><i class="fa fa-refresh" aria-hidden="true"></i> Alterar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->


    </div>
<!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->