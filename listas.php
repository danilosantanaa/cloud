<?php
    require_once("config.php");
    require_once("includes/funcao.php");

    verificarLogin();
    
    require_once("header.php");
?>
       
    <div class="main-panel">

        <?php
            require_once('header_user.php')
        ?>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card strpied-tabled-with-hover">
                            <div class="card-header ">
                                <h4 class="card-title">Lista de Clientes</h4>
                                <p class="card-category">Aqui está a listagem com todos os clientes.</p>
                            </div>
                            <div class="card-body table-full-width table-responsive">
                        
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <th>ID</th>
                                        <th>Nome</th>
                                        <th>Email</th>
                                        <th>Telefone</th>
                                        <th> </th>
                                    </thead>
                                    <tbody>

                                        <?php
                                            $sql = "SELECT * FROM tb_cliente";
                                            $stmt = $conn->query($sql);
                                            
                                            while ($row = $stmt->fetch()) {
                                                echo "<tr>
                                                        <td>". $row['id'] . "</td>
                                                        <td>". $row['nome'] . "</td>
                                                        <td>". $row['email'] . "</td>
                                                        <td>". $row['telefone'] . "</td>
                                                        <td>
                                                        <a title='Editar' class='button editar' href='index.php?id=". $row['id'] ."'><i class=\"fa-solid fa-pen\"></i></a>&nbsp;
                                                        <a title='Apagar' class='button apagar' href='api/api_pessoa.php?action=DEL&id=". $row['id'] ."'><i class=\"fa-solid fa-trash\"></i></a>
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

<script>
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
                                                window.location.href = 'listas.php'
                                            }
                                        });
                            })
                            .catch(erro => console.log(erro));
                        }
                    });
                
               
            });
        }
    }
    
</script>

</html>
