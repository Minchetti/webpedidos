<div class="container">
        <h2 style="text-align:center">PAINEL DE RECEBIMENTO DE MERCADORIAS</h2>
        
        <button type="button" class="btn btn-danger" onclick="function deleteCookie(){
                                                                                console.log('Hi!');
                                                                                document.cookie = '_CNPJ_Access=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
                                                                                document.cookie = '_Filial_Access=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
                                                                                document.cookie = '_Matricula_Access=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
                                                                                document.cookie = '_Token_Access=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
                                                                                document.cookie = '_Access=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
                                                                                $(location).attr('href', 'recebimento');
                                                                        }; deleteCookie()
                                                                ">LOGOUT</button>

        <!-- MM -->
        <div class="row"> 
                <div class="col-lg-12">
                <hr class="invisible">
                
                        <!-- <form method="post" action="recebe" enctype="multipart/form-data" >         -->
                                <div id="tableRecebimento" style="display:none;" class="table table-hover table-bordered table-striped">
                                        <div class="d-flex" style="background: rgb(34,34,34); color: rgb(255, 255, 255);    
                                                                   padding-top: 5px; padding-bottom: 5px; ">
                                                <!-- <div > -->
                                                        <div style="width: 210px;" class="text-center">Código</div>
                                                        <!-- <th class="text-center">Data de Emissão</th> -->
                                                        <div style="width: 200px;" class="text-center">Recebido?</div>
                                                        <div style="width: 370px;" class="text-center">Arquivo</div>
                                                        <div style="width: 330px;" class="text-center">Ação</div>
                                                <!-- <div> -->
                                        </div>
                                        <div id="listar-recebimento"></div>
                                        <div>
                                        <div>
                                                <div colspan="10" id="paginacao-templates"></div>
                                        </div>
                                        </div>
                                </div>
                        <!-- </form> -->
                </div>
        </div>



</div> <!-- /container -->

<style>
        .d-flex{
                display:flex;
        }

</style>