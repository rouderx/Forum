<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <?php if ($_SERVER['REQUEST_URI']=='/home'){?>
                <div class="navbar-brand" ><div class="navbar-t">Nový príspevok</div></div>
            <?php } else if(strtok($_SERVER["REQUEST_URI"],'?')=='/thread'){ ?>
                <div class="navbar-brand" ><div class="navbar-t">Komentovať</div></div>
            <? } ?>
        </div>

        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav links">
                <li><a href="/">HOME</a></li>
                <?php if(isset($_SESSION['user']) && $_SESSION['user'] != "")
                    echo"<li><a href='/home'>FORUM</a></li>"; ?>
            </ul>
            <ul class="nav navbar-nav navbar-right links">
            <?php if(!isset($_SESSION['user']) && $_SESSION['user'] == ""):?>
            	<li><a href='/auth/login'>PRIHLÁSENIE</a></li>
                <li><a href='/auth/register'>REGISTRÁCIA</a></li>
            <?php else: ?>
            	<li class='dropdown'>
                    <a href='' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'>
                        <?php echo $_SESSION['user']; ?> <span class='caret'></span>
                    </a>

                    <ul class='dropdown-menu' role='menu'>
                        <li>
                            <a href='/profile'>Profil</a>
                        </li>
                        <li>
                            <a href='/logout' onclick='event.preventDefault(); document.getElementById('logout-form').submit();'>
                                Odhlásenie
                            </a>
                            <form id='logout-form' action='' method='POST' style='display: none;'></form>
                        </li>
                    </ul>
                </li>
            <?php endif ?>
            </ul>
        </div>
    </div>
</nav>