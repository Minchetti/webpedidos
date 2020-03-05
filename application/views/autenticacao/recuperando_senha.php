    <div class="container">

    <?php if( ! isset($erro)) : ?>
        <input type="hidden" id="fs" name="fs" value="<?php echo $fs;?>">
        <input type="hidden" id="fs-log" name="fs-log" value="<?php echo $fslog;?>">
        <form class="form-signin" style="height: 420px;">
            <div class="form-group">
                <img class="img-responsive center-block" src="<?php echo base_url('assets/images/logo/logoLogin.jpg'); ?>" alt="Fitassul" title="Fitassul"/>
            </div>
            <div class="form-group">
                <div class="alert alert-info">
                    <p>
                        <strong><i class="glyphicon glyphicon-exclamation-sign"></i> Digite e confirme a nova senha</strong>
                    </p>
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <label for="txtSenha" class="sr-only">Senha</label>
                    <span class="input-group-addon"><i class="fa fa-lock" aria-hidden="true"></i></span>
                    <input id="txtSenha" type="password" name="senha" class="form-control" placeholder="Senha" />
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <label for="txtConfirmarSenha" class="sr-only">Confirmar senha</label>
                    <span class="input-group-addon"><i class="fa fa-lock" aria-hidden="true"></i></span>
                    <input id="txtSenhaConfirmar" type="password" name="confirmar-senha" class="form-control" placeholder="Confirmar Senha" />
                </div>
            </div>
            <div class="form-group">
                <div id="avisos-alterar-dados"></div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <button id="btn-alterar-senha" class="btn btn-primary" disabled><i class="fa fa-refresh" aria-hidden="true"></i> Alterar</button>
                </div>
            </div>
        </form>
        <?php else : ?>

        <h3><div class="alert alert-danger"><?php echo $erro; ?></div></h3>
        <?php endif; ?>
    </div> <!-- /container -->