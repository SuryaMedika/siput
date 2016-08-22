<?php include("inc/header.php"); ?>

    <!--login screen-->
    <div class="login-screen">
        
        <!--login logo-->
        <div class="login-logo">
            <a href="index.php" style="color:silver;">
                <i class="fa fa-5x fa-medkit" aria-hidden="true"></i>
            </a>
        </div>
        <?php if(!$_GET['aksi']){ 

            if($_POST['login']){
                $user   = $_POST['username'];
                $pass   = $_POST['password'];

                //untuk menentukan expire cookie, dihtung dri waktu server + waktu umur cookie          
                $time = time();                 
                //cek jika setcookie di cek set cookie jika tidak ''
                $check = isset($_POST['setcookie'])?$_POST['setcookie']:'';

                if($user && $pass){
                    $cek = mysql_query("SELECT * FROM pegawai WHERE pegawai_username='$user'");

                    if(mysql_num_rows($cek) != 0){
                        $data = mysql_fetch_assoc($cek);

                        if($user == $data['pegawai_username'] && md5($pass) == $data['pegawai_password']){
                            $_SESSION['pegawai_login'] = $user;
                            $_SESSION['pegawai_level'] = $data['pegawai_level'];
                            $_SESSION['logged'] = 1; 
                            //jika remembere me, set cookie
                            if($check) {        
                                setcookie("cookielogin[user]",$user , $time + 3600);        
                                setcookie("cookielogin[pass]", $pass, $time + 3600);    
                            }
                            echo '<script language="javascript">alert("Anda berhasil login sebagai '.$data['pegawai_level'].'."); document.location="index.php";</script>';

                        }else{
                            echo '<div class="message error box-">ERROR: Login Gagal.</div>';
                        }
                    }else{
                        echo '<div class="message warning box-">ERROR: Username tidak terdaftar.</div>';
                    }
                }else{
                    echo '<div class="message info box-">ERROR: Yang bertanda * tidak boleh kosong.</div>';
                }
            }
        ?>

        <form method="post" action="">
            <ul>
                <li>
                    <label for="username">Nama Pengguna *</label>
                    <input type="text" name="username" id="username">
                </li>
                <li>
                    <label for="password">Kata Kunci *</label>
                    <input type="password" name="password" id="password">
                </li>
                <li>
                    <button type="submit" name="login" value="login" onclick="this.value='login'">Login</button>
                    <label for="remember" class="checkbox">
                        <input type="checkbox" name="setcookie" value="true" id="remember"> Ingat aku.
                    </label>
                </li>
            </ul>
        </form>

        <?php 
        } 
        ?>

        <?php 
        if($_GET['aksi'] == "logout"){

            session_start();
            session_unset();
            session_destroy();

            if(isset($_COOKIE['cookielogin'])) {
                $time = time();
                setcookie("cookielogin[user]", $time - 3600);
                setcookie("cookielogin[pass]", $time - 3600);
            }

            header("Location: login.php");
        }
        ?>

    </div>

<?php include("inc/footer.php"); ?>