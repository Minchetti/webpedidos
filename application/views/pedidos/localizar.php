<style>
    select.ui-datepicker-month, select.ui-datepicker-year{
        color: rgb(0, 0, 0);
    }
</style>

<div id="page-wrapper">

    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <i class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></i> Pedidos
                </h1>
            </div>
        </div>
        <!-- /.row -->

        <!-- Criteria -->
        <div class="row">
            <!-- Número requisição -->
            <!-- <div class="col-lg-2">
                <div class="form-group">
                    <label>Nº pedido inicial</label>
                    <input id="num-inicial" type="text" name="num-inicial" class="form-control" title="Digite apenas números" placeholder="Nº Pedido" />
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label>Nº pedido final</label>
                    <input id="num-final" type="text" name="num-final" class="form-control" title="Digite apenas números" placeholder="Nº Pedido" />
                </div>
            </div> -->

            <!-- Período -->
            <div class="col-lg-2 ">
                <div class="form-group">
                    <label>Data inicial</label>
                    <input id="data-inicial" type="text" name="data-inicial" class="form-control" title="Digite apenas números" placeholder="Data inicial" maxlength="8"/>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label>Data final</label>
                    <input id="data-final" type="text" name="data-final" class="form-control" title="Digite apenas números" placeholder="Data Final" maxlength="8"/>
                </div>
            </div>
        </div>
        <!-- /.row -->

        <div class="row">
            <!-- Funcionário -->
            <div class="col-lg-2">
                <div class="form-group">
                    <label>Matrícula</label>
                    <input id="txtFuncionario" type="text" name="matricula" class="form-control" placeholder="Matricula" <?php (filter_var($this->session->aprovador, FILTER_VALIDATE_BOOLEAN)) ? print('') : print('disabled');?>/>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-group">
                    <label>Funcionário</label>
                    <input id="txtNomeFuncionario" type="text" name="nome-funcionario" class="form-control" placeholder="Nome" <?php (filter_var($this->session->aprovador, FILTER_VALIDATE_BOOLEAN)) ? print('') : print('disabled')?>/>
                </div>
            </div>
            
            <div class="col-lg-2">
                <div class="form-group">
                    <label>Turno</label>
                    <select id="cbTurno" name="turno" class="form-control">
                        <option value="0" selected >TODOS</option>
                        <option value="1">PRIMEIRO</option>
                        <option value="2">SEGUNDO</option>
                        <option value="3">TERCEIRO</option>
                        <option value="4">ADMINISTRATIVO</option>
                    </select>
                </div>
            </div>

        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-lg-2">
                <label>Status requisição</label>
                <select id="cbStatusRequisicao" name="status-requisicao" class="form-control">
                    <option value="Todos" selected>TODOS</option>
                    <option value="Aberto">ABERTO</option>
                    <option value="Fechado">FECHADO</option>
                </select>
            </div>

            <div class="col-lg-2 col-lg-offset-9">
                <label>&nbsp;</label><br />
                <button id="btnBuscar" class="btn btn-danger"><i class="glyphicon glyphicon-search"></i> Buscar</button>
            </div>
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-lg-12">
                <hr class="invisible">
                <table class="table table-hover table-striped"> <!-- table-bordered -->
                    <thead style="background: rgb(34,34,34); color: rgb(255, 255, 255);">
                        <tr>
                            <th>Número</th>
                            <th>Funcionário</th>
                            <th>Turno</th>
                            <th>CC</th>
                            <th>Setor</th>
                            <th>Emissão</th>
                            <th>Status</th>
                            <th>Solicitante</th>
                            <th>Detalhes</th>
                        <tr>
                    </thead>
                    <tbody id="resultado-consulta"></tbody>
                    <tfoot>
                        <tr>
                            <td colspan="10" id="paginacao-pedidos"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <!-- /.row -->
    </div>
<!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->

<!-- Modal Detalhes do pedido -->
<div id="detalhes-pedido" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-file-text-o" aria-hidden="true"></i> Detalhes do pedido Nº <strong id="num-pedido-detalhe"> </strong></h4>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-lg-6">
                <p><strong><i class="fa fa-id-card" aria-hidden="true"></i> Funcionário: </strong> <span id="funcionario-detalhe"></span></p>
            </div>
            <div class="col-lg-6">
                <p><strong><i class="fa fa-calendar-o" aria-hidden="true"></i> Emissão: </strong> <span id="emissao-detalhe"></span></p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <p><strong><i class="fa fa-truck" aria-hidden="true"></i> Local da entrega: </strong> <span id="entrega-detalhe"></span></p>
            </div>
            <div class="col-lg-6">
                 <p><strong><i class="fa fa-clock-o" aria-hidden="true"></i> Turno: </strong> <span id="turno-detalhe"></span></p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <p><strong><i class="fa fa-info-circle" aria-hidden="true"></i> Observação: </strong> <span id="observacao-detalhe"></span></p>
            </div>
        </div>
        <hr />
        <!-- Tabela de itens -->
        <table class="table table-hover table-bordered table-striped">
            <thead>
                <tr>
                    <td>Código</td>
                    <td>Produto</td>
                    <td>CA</td>
                    <td>Unidade</td>
                    <td class="text-center">Quantidade</td>
                </tr>
            </thead>
            <tbody id="detalhes-itens"></tbody>
        </table>

      </div>
      <div class="modal-footer">
      
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Fechar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->