<?php

// Create id attribute allowing for custom "anchor" value.
$id = 'meal_' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}


$meal_area = get_field('area');


?>

<style>
        #meal.meal-loading .meal-id,
        #meal.meal-loading .meal-name,
        #meal.meal-loading .meal-area{
            background: #ccc;
        }

        #meal.meal-error .meal-id,
        #meal.meal-error .meal-name,
        #meal.meal-error .meal-area{
            background: #a00;
        }


        .meal-id{
            font-weight: lighter;
            font-size: 16px;
            text-align: right;
        }

        .meal-name{
            font-weight: bold;
            text-align: center;
        }

        .meal-area{
            color: rgb(66, 65, 65);
            font-size: 20px;
            text-align: center;
        }

        .mealImg{
            width: 20px;
            height: 30px;
            margin-right: 5px;
        }

        .meal-photo{
            width: 330px;
            height: 330px;
            margin-right: 1em;
        }

        .flex-area{
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            background-color: #ffffff;
            border-radius: 10px;
            padding: 7px;

        }

        .inizio{
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            padding: 1em;
        }

        .inizio div{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .body{
            border-radius: 10px;
            border: 2px solid #000000;
            padding: 20px;
        }

        p{
            margin: 0;
        }



    </style>

    <!-- il mio blocco --> 
    <div id="<?php echo $id; ?>" class="meal-loading body">
        <p class="meal-id">&nbsp;</p>
        <h2 class="meal-name">&nbsp;</h2>
        <div class="inizio">
            <img class="meal-photo" src="" alt="">
            <div>
                <div class="flex-area">
                    <img class="mealImg" src="<?php echo 'http://wpadv.local/wp-content/plugins/wpadv-plugin/utensils.svg'; ?>" alt="">
                    <p class="meal-area"><?php echo $meal_area; ?></p>
                </div>
            </div>
        </div> 
    </div>
    

    <script> 
        
        fetch ('https://www.themealdb.com/api/json/v1/1/filter.php?a=<?php echo $meal_area; ?>')
        .then(response => response.json())
        .then(data => populate_<?php echo $id; ?>(data))
        .catch(e => errorCall_<?php echo $id; ?>());

        
        function populate_<?php echo $id; ?>(meal) {
            console.log(meal);
            
            let mealClass = document.querySelector("#<?php echo $id; ?>");

            // PRENDO L'ID
            let mealId = document.querySelector("#<?php echo $id; ?> .meal-id");
            mealId.innerHTML = meal.meals[0].idMeal;

            // PRENDO IL NOME
            let mealName = document.querySelector("#<?php echo $id; ?> .meal-name");
            mealName.innerHTML = meal.meals[0].strMeal;

            // PRENDO LA FOTO
            let mealImg = document.querySelector("#<?php echo $id; ?> .meal-photo");
            mealImg.src = meal.meals[0].strMealThumb;

            mealClass.classList.remove("meal-loading");
            mealClass.classList.add("meal-loaded");
        }

        // ERROR CALL
        function errorCall_<?php echo $id; ?>() {
            let mealClass = document.querySelector("#<?php echo $id; ?>");
            mealClass.classList.remove("meal-loading");
            mealClass.classList.add("meal-error");
        }


    </script>