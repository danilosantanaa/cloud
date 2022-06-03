<?php
    require_once("config.php");
    require_once("includes/funcao.php");

    verificarLogin();

    // Verificar se houver edição de dados

    require_once("header.php");
?>
        <div class="main-panel">
            <!-- Navbar -->

            <?php
                $id = $_GET['id'] ?? 0;

                $dst = $id  <= 0  ? "CRIAR" : "EDITAR";
                $buttonText = $id == 0 ? "Salvar" : "Editar";

                $field = array(
                    "nome" => "",
                    "email" => "",
                    "telefone" => ""
                );


                if($id > 0) {
                    $sql = "SELECT * FROM tb_cliente WHERE id = :ID";

                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(":ID", $id, PDO::PARAM_STR);
                    $stmt->execute();

                    $result = $stmt->fetchAll();
                    
                    if(count($result) > 0) {
                        $field['nome'] = $result[0]['nome'] ?? "";
                        $field['email'] = $result[0]['email'] ?? "";
                        $field['telefone'] = $result[0]['telefone'] ?? "";
                    }
                }

            ?>

            <?php
                require_once('header_user.php')
            ?>
            
            <!-- End Navbar -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title"><?php echo $field['nome'] != "" ? "Editar " . $field['nome'] : "Novo Cadastro" ?></h4>
                                </div>
                                <div class="card-body">

                                    <form action="api/api_pessoa.php?action=<?php echo $dst ?>" method="post" id="form">
                                    
                                        <div style="padding: 10px;">
                                            <div class="row">

                                                <?php 
                                                    if($id > 0 && count($result) > 0) {
                                                ?>
                                                    <input type="hidden" id="idOculto" name="idUser" value="<?php echo $id ?>"/>
                                                <?php
                                                    }
                                                ?>

                                                <div class="col-md-3 px-1">
                                                    <div class="form-group">
                                                        <label>Nome</label>
                                                        <input type="text" name="nome" class="form-control" placeholder="nome" value="<?php echo  $field['nome']?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 pl-1">

                                                    
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Email <span id="statusEmail" style="color: red;"></span></label>
                                                        <input type="email" name="email" class="form-control" placeholder="Email" id="email" value="<?php echo  $field['email']?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 pl-1">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">telefone</label>
                                                        <input type="text" name="telefone" class="form-control" placeholder="Telefone" value="<?php echo  $field['telefone']?>">
                                                    </div>
                                                </div>
                                            </div>
                                        
                                            <div class="row">
                                            <button type="submit" class="btn btn-info btn-fill pull-right"><i class="fa-solid fa-floppy-disk"></i> <?php echo $buttonText ?></button>
                                            <div class="clearfix"></div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        <?php
            require_once("footer.php");
        ?>
    </div>
</body>

<script>
    const form = document.querySelector("#form")

    const email = document.querySelector("#email");

    let emailValido = false
    email.addEventListener("focusout", () => {
        let id = document.querySelector("#idOculto");
        let url = `api/api_pessoa.php?action=CEMAIL&email=${email.value}${id != null ? "&id=" + id.value : ""}`;

        console.log(url)
        let pattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;

        emailValido = pattern.test(email.value);
        
        if(emailValido) {
            
            fetch(url)
                .then(resp => resp.json())
                .then(json => {
                    emailValido = json[0] == 0;
                    email.style.border = '1px solid ' + ( emailValido  ? " #E3E3E3" : "red" );
                    document.querySelector("#statusEmail").innerHTML = !emailValido ? "Já se encontrada cadastrado!" : "";
                })
                .catch(erro => console.log(erro));
        }else if(email.value != "") {
            Swal.fire('Erro!', "O e-mail deve possuí somente esses caracteres (^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$)", 'error')
        }
    });

    form.addEventListener("submit", e => {
       e.preventDefault();

       
       try {
           if(!emailValido && <?php echo $id == 0 ? "true" : "false" ?>) throw "Há campo inválido que precisa corrigir";

            const form = e.target;
            const data = new FormData(form);

            const options = {
                method: form.method,
                body: new URLSearchParams(data)
            }

            fetch(form.action, options)
                .then(resp => resp.json())
                .then(json => {
                    if(json.erro != undefined) throw json.erro;

                    Swal.fire('Salvo com sucesso!', e, 'success')
                       
                        .then(result => {
                            if(result.isConfirmed) {
                                window.location.href = 'listas.php'
                            }
                        })
                })
                .catch(erros =>  Swal.fire('Erro!', erros, 'error'));
       }catch(e) {
            Swal.fire('Erro!', e, 'error');
       }

     });

</script>

</html>
