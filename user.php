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
                        $field['usuario'] = $result[0]['nome'] ?? "";
                        $field['senha'] = $result[0]['senha'] ?? "";
                        $field['is_admin'] = $result[0]['telefone'] ?? "";
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

                                    <form action="api/api_usuario.php?action=<?php echo $dst ?>" method="post" id="form">
                                    
                                        <div style="padding: 10px;">
                                            <div class="row">

                                                <?php 
                                                    if($id > 0 && count($result) > 0) {
                                                ?>
                                                    <input type="hidden" id="idOculto" name="idUser" value="<?php echo $id ?>"/>
                                                <?php
                                                    }
                                                ?>

                                                <div class="col-md-4 pl-1">
                                                    <div class="form-group">
                                                        <label for="usuario">Usuário <span id="statusUser" style="color: red;"></span></label>
                                                        <input type="text" name="usuario" class="form-control" placeholder="usuario" id="usuario">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 pl-1">
                                                    <div class="form-group">
                                                        <label for="senhaID">Senha</label>
                                                        <input type="password" name="senha" id="senhaID" class="form-control" placeholder="Senha">
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <div>
                                                <div class="col-md-4 pl-1">
                                                    <div class="form-group">
                                                        <input type="checkbox" name="isadmin" id="is_admin" value="T">
                                                        <label for="is_admin">ATIVO</label>
                                                    </div>
                                                </div>
                                            </div>
                                        
                                            <div class="row">
                                            <button type="submit" class="btn btn-info btn-fill pull-right"><i class="fa-solid fa-floppy-disk"></i> Salvar</button>
                                            <div class="clearfix"></div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card strpied-tabled-with-hover">
                            <div class="card-header ">
                                <h4 id="user" class="card-title">Lista de Clientes</h4>
                                <p class="card-category">Aqui está a listagem com todos os usuário.</p>
                            </div>
                            <div class="card-body table-full-width table-responsive">
                        
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <th>ID</th>
                                        <th>Usuario</th>
                                        <th>Senha</th>
                                        <th>Ativo</th>
                                        <th> </th>
                                    </thead>
                                    <tbody>

                                        <?php
                                            $sql = "SELECT * FROM tb_usuario where id != {$_SESSION['id']}";
                                            $stmt = $conn->query($sql);
                                            
                                            while ($row = $stmt->fetch()) {
                                                echo "<tr>
                                                        <td>". $row['id'] . "</td>
                                                        <td>". $row['usuario'] . "</td>
                                                        <td>*************</td>
                                                        <td><input type='checkbox' id_user='". $row['id'] ."'' ". ($row['is_admin'] == '1' ? "checked" : "") ." class='atv_user'/></td>
                                                        <td>
                                                        <a title='Apagar' class='button apagar' href='api/api_usuario.php?action=DEL&id=". $row['id'] ."'><i class=\"fa-solid fa-trash\"></i></a>
                                                        </td>
                                                    </tr>";
                                            }
                                        ?>
                                        
                                    </tbody>
                                </table>
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
<!--   Core JS Files   -->
<script src="templetes/light-bootstrap-dashboard/assets/js/core/jquery.3.2.1.min.js" type="text/javascript"></script>
<script src="templetes/light-bootstrap-dashboard/assets/js/core/popper.min.js" type="text/javascript"></script>
<script src="templetes/light-bootstrap-dashboard/assets/js/core/bootstrap.min.js" type="text/javascript"></script>
<!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
<script src="templetes/light-bootstrap-dashboard/assets/js/plugins/bootstrap-switch.js"></script>
<!--  Google Maps Plugin    -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
<!--  Chartist Plugin  -->
<script src="templetes/light-bootstrap-dashboard/assets/js/plugins/chartist.min.js"></script>
<!--  Notifications Plugin    -->
<script src="templetes/light-bootstrap-dashboard/assets/js/plugins/bootstrap-notify.js"></script>
<!-- Control Center for Light Bootstrap Dashboard: scripts for the example pages etc -->
<script src="templetes/light-bootstrap-dashboard/assets/js/light-bootstrap-dashboard.js?v=2.0.0 " type="text/javascript"></script>
<!-- Light Bootstrap Dashboard DEMO methods, don't include it in your project! -->
<script src="templetes/light-bootstrap-dashboard/assets/js/demo.js"></script>

<script>
    const form = document.querySelector("#form")

    const usuario = document.querySelector("#usuario");

    let usuarioValido = false
    usuario.addEventListener("focusout", () => {
        let id = document.querySelector("#idOculto");
        let url = `api/api_usuario.php?action=CUSER&usuario=${usuario.value}${id != null ? "&id=" + id.value : ""}`;

        console.log(url)
        let pattern = /^[a-zA-Z0-9._-]+$/;

        usuarioValido = pattern.test(usuario.value);
        
        if(usuarioValido) {
            
            fetch(url)
                .then(resp => resp.json())
                .then(json => {
                    usuarioValido = json[0] == 0;
                    usuario.style.border = '1px solid ' + ( usuarioValido  ? " #E3E3E3" : "red" );
                    document.querySelector("#statusUser").innerHTML = !usuarioValido ? "Já se encontrada cadastrado!" : "";
                })
                .catch(erro => console.log(erro));
        } else if(usuario.value != "") {
            Swal.fire('Erro!', "Usuario inválido. So aceita caracteres (A-Z a-z 0-9 ._-)", 'error')
        }
    });

    form.addEventListener("submit", e => {
       e.preventDefault();

       try {
           if(!usuarioValido && <?php echo $id == 0 ? "true" : "false" ?>) throw "Há campo inválido que precisa corrigir";

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
                                window.location.href = 'user.php'
                            }
                        })
                })
                .catch(erros =>  Swal.fire('Erro!', erros, 'error'));
       }catch(e) {
            Swal.fire('Erro!', e, 'error');
       }

     });


    /** Botão de deletar usuário */
    const deleteData = document.querySelectorAll("table tr a.apagar");
    if(deleteData != null && deleteData != undefined) {
        for(let i = 0; i < deleteData.length; i++) {
            deleteData[i].addEventListener("click", e => {
                e.preventDefault();

                Swal.fire({
                    title: 'Tem certeza que deseja apagar?',
                    text: "",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sim',
                    cancelButtonText: 'Não'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(deleteData[i].href)
                                .then(resp => resp.json())
                                .then(json => {
                                    let msg = json.erro != undefined ? json.erro : json.sucesso;

                                    Swal.fire('Deletado com sucesso!', json.msg, json.erro == undefined ? 'success' : 'error')
                                        .then(result => {
                                            if(result.isConfirmed) {
                                                window.location.href = 'user.php'
                                            }
                                        });
                            })
                            .catch(erro => console.log(erro));
                        }
                    });
                
               
            });
        }
    }

    /* Script para habilitar e desabilitar usuário */
    const checkboxs = document.querySelectorAll('.atv_user');

    for(let i = 0; i < checkboxs.length; i++) {
        checkboxs[i].addEventListener("click", () => {
            let id =  checkboxs[i].getAttribute('id_user');
            let checked = checkboxs[i].checked ? "1" : "0";

            let url = `api/api_usuario.php?action=CATV&id=${id}&atv=${checked}`;
            console.log(url);

            fetch(url)
                .then(response => response.json())
                .then(async json => {

                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-right',
                        iconColor: 'white',
                        customClass: {
                            popup: 'colored-toast'
                        },
                        showConfirmButton: false,
                        timer: 1500,
                        timerProgressBar: true
                    });

                    if(json.erro != undefined || json.erro != null) {
                        await Toast.fire({
                            icon: 'error',
                            title: json.erro
                        });
                        checkboxs[i].checked = !checkboxs[i].checked;
                    } else {
                        await Toast.fire({
                            icon: 'success',
                            title: json.sucesso
                        });

                    }
                    

                }).catch(error => {
                    console.log(error);
                    checkboxs[i].checked = !checkboxs[i].checked;
                });
        });
    }

</script>

</html>
