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
                    <i class="fa fa-line-chart" aria-hidden="true"></i> Relatório
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
                    <input id="data-inicial" type="text" name="data-inicial" class="form-control" title="Digite apenas números" placeholder="Data inicial" maxlength="10"/>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label>Data final</label>
                    <input id="data-final" type="text" name="data-final" class="form-control" title="Digite apenas números" placeholder="Data Final" maxlength="10"/>
                </div>
            </div>
        </div>
        <!-- /.row -->

        <div class="row">
            <!-- Funcionário -->
            <div class="col-lg-2">
                <div class="form-group">
                    <label>Matrícula</label>
                    <input id="txtFuncionario" type="text" name="matricula" class="form-control" placeholder="Matricula" disabled/>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="form-group">
                    <label>Funcionário</label>
                    <input id="txtNomeFuncionario" type="text" name="nome" class="form-control" placeholder="Nome" />
                </div>
            </div>

            <div class="col-lg-4">
                <div class="form-group">
                    <label>Setor</label>
                    <input id="txtSetorRelatorio" type="text" name="setor" class="form-control" placeholder="Setor" />
                </div>
            </div>

            <!-- <div class="col-lg-2">
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
            </div> -->

        </div>
        <!-- /.row -->

        <div class="row">
            <!-- Status aprovação -->
            <div class="col-lg-2">
                <label>Status aprovacao</label>
                <select id="cbStatusAprovacao" name="status-aprovacao" class="form-control">
                    <option value="Todos" selected>TODOS</option>
                    <option value="Aprovado">APROVADO</option>
                    <option value="Aguardando">AGUARDANDO</option>
                </select>
            </div>
<!-- 
            <div class="col-lg-2">
                <label>Status requisição</label>
                <select id="cbStatusRequisicao" name="status-requisicao" class="form-control">
                    <option value="Todos" selected>TODOS</option>
                    <option value="Aberto">ABERTO</option>
                    <option value="Carrinho">CARRINHO</option>
                    <option value="Faturar">FATURAR</option>
                    <option value="Fechado">FECHADO</option>
                    <option value="Pendente">PENDENTE</option>
                </select>
            </div> -->

            <div class="col-lg-2 col-lg-offset-2">
                <label>&nbsp;</label><br />
                <button id="btnBuscar" class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i>
 Gerar</button>
            </div>
        </div>
        <!-- /.row -->

        <!-- <div class="row">
            <div class="col-lg-12">
                <hr class="invisible">
                <table class="table table-hovered">
                    <thead>
                        <tr>
                            <th>Número</th>
                            <th>Funcionário</th>
                            <th>Emissão</th>
                            <th>Status</th>
                            <th>Usuário</th>
                            <th>Aprovação</th>
                            <th>Detalhes</th>
                        <tr>
                    </thead>
                    <tbody id="resultado-consulta"></tbody>
                </table>
            </div>
        </div>
        /.row -->




        <div class="row"> 
                    <div class="col-lg-12">
                        <hr class="invisible">
                        <table id="tablerelatorios" style="display:none;" class="table table-hover table-bordered table-striped">
                            <thead style="background: rgb(34,34,34); color: rgb(255, 255, 255);">
                                <tr>
                                    <th><small>Req</small></th>
                                    <th><small>Entrega</small></th>
                                    <th><small>Faturamento</small></th>
                                    <th><small>CC</small></th>
                                    <th><small>Funcionario</small></th>
                                    <th><small>Matrícula</small></th>
                                    <th><small>Produto</small></th>
                                    <th><small>PartNumber</small></th>
                                    <th><small>CA</small></th>
                                    <th><small>Qntd</small></th>
                                    <th><small>Valor Un.</small></th>
                                    <th><small>Valor Total</small></th>
                                    <th><small>Emissão</small></th>
                                    <th><small>Solicitante</small></th>
                                    <th><small>Solicitante Matrícula</small></th>
                                    <th><small>Local Entrega</small></th>
                                <tr>
                            </thead>
                            <tbody id="listar-relatorio"></tbody>
                            <tfoot>
                                <!-- <tr>
                                    <td colspan="10" id="paginacao-templates"></td>
                                </tr> -->
                            </tfoot>
                        </table>
                    </div>
                </div>





    </div>
<!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->