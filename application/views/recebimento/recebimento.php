<div class="container">
            <form class="form-signin" style="height:auto !important;">
                <div class="form-group">
                    <img class="img-responsive center-block" src="<?php echo base_url('assets/images/logo/logoLogin.jpg'); ?>" alt="Fitassul" title="Fitassul"/>
                </div>
        
                <div class="form-group">
                <div class="input-group">
                    <label for="lista-empresas" class="sr-only">Empresas</label>
                    <select id="lista-empresas" name="" class="form-control"></select>
                </div>
            </div>
            
            <div class="form-group" id="div-sub-empresas">
                <div class="input-group">
                    <label for="lista-sub-empresas" class="sr-only">Empresas</label>
                    <select id="lista-sub-empresas" name="" class="form-control"></select>
                </div>
            </div>
            
            <div class="form-group">
                <div class="input-group">
                    <!-- <label for="txtMatricula" class="sr-only">Senha</label> -->
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input id="txtMatricula" type="text" class="form-control" placeholder="Matrícula" aria-describedby="txtMatricula" />
                </div>
            </div>
        
            <div class="form-group">
                <div id="avisos"></div>
            </div>
        
            <div class="form-group login-button">
                <button id="btn-enviar-token" class="btn btn-lg btn-danger btn-block" disabled><i class="glyphicon glyphicon-log-in"></i> Enviar Token</button>
            </div>


            
            <div class="form-group" style="margin-top: 50px;">
                <div class="input-group">
                    <label for="txtToken" class="sr-only">Token</label>
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    <input id="txtToken" type="password" class="form-control" placeholder="Token" aria-describedby="txtToken" />
                </div>
            </div>
        
        <div class="form-group login-button">
            <button id="btn-entrar-recebimento" class="btn btn-lg btn-danger btn-block" disabled><i class="glyphicon glyphicon-log-in"></i> Entrar</button>
        </div>
            
      </form>
    </div> <!-- /container -->