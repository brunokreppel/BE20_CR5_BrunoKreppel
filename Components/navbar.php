<?php 
echo
"<nav class='navbar navbar-expand-lg navbar' style='background-color: #ffffff;'>
    <div class='container-fluid'>
        <a class='navbar-brand' href='/php/BE20_CR5_BrunoKreppel/index.php'><img width='28' height='28' src='https://img.icons8.com/ios/28/animal-shelter.png' alt='animal-shelter' class='pb-1'/> Animal-Shelter</a>
        <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarNav'
            aria-controls='navbarNav' aria-expanded='false' aria-label='Toggle navigation'
            style='outline: none; border: none !important; box-shadow: none !important;'> 
            <span class='navbar-toggler-icon'></span>
        </button>
        <div class='collapse navbar-collapse' id='navbarNav'>
            <ul class='navbar-nav'>
                <li class='nav-item'>
                    <a class='nav-link' href='/php/BE20_CR5_BrunoKreppel/index.php'>Home</a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link' href='/php/BE20_CR5_BrunoKreppel/animals/create.php'>Create</a>
                </li>
                <li class='nav-item'>
                  <a class='nav-link' href='/php/BE20_CR5_BrunoKreppel/animals/oldtimer.php'>Oldtimer</a>
                </li>
                
                ";

                if (isset($_SESSION["user"]) || isset($_SESSION["adm"]) ){
                 
                    echo "
                        
                    
                    <li class='nav-item'>
                    <a class='nav-link' href='/php/BE20_CR5_BrunoKreppel/user/logout.php'>Logout</a>
                    </li>

                    <li class='nav-item'>
                    <a class='nav-link' href='/php/BE20_CR5_BrunoKreppel/user/profile.php'>Profile</a>
                    </li>

                    <li class='nav-item'>
                    <a class='nav-link' href='/php/BE20_CR5_BrunoKreppel/user/update.php'>Update</a>
                    </li>
                    
                    ";
                }
                else{
                    echo "
                    <li class='nav-item'>
                    <a class='nav-link' href='/php/BE20_CR5_BrunoKreppel/user/register.php'>Register</a>
                    </li>
                    <li class='nav-item'>
                    <a class='nav-link' href='/php/BE20_CR5_BrunoKreppel/user/login.php'>Login</a>
                    </li>
                    
                    ";
                } 
                if(isset($_SESSION["adm"])){
                    echo "
                    <li class='nav-item'>
                    <a class='nav-link' href='/php/BE20_CR5_BrunoKreppel/user/dashboard.php'>Dashboard</a>
                    </li>
                    <li class='nav-item'>
                    <a class='nav-link' href='/php/BE20_CR5_BrunoKreppel/animals/animalDashboard.php'>Animal-Dashboard</a>
                    </li>
                    ";

                }


            echo "</ul>
        </div>
    </div>
</nav>";
?>
