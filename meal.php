<?php

// Create id attribute allowing for custom "anchor" value.
$id = 'meal_' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}


$meal_name = get_field('name');


?>

<style>
        #meal.meal-loading .meal-id,
        #meal.meal-loading .meal-name,
        #meal.meal-loading .meal-area,
        #meal.meal-loading .meal-ingredients,
        #meal.meal-loading .meal-instructions{
            background: #ccc;
        }

        #meal.meal-error .meal-id,
        #meal.meal-error .meal-name,
        #meal.meal-error .meal-area,
        #meal.meal-error .meal-ingredients,
        #meal.meal-error .meal-instructions{
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

        .meal-instructions{
            font-size: 18px;
            text-align: center;
        }

        i{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
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
            background-color: <?php the_field('background_color'); ?>;
        }

        h5{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        p{
            margin: 0;
        }

        .meal-ingredients{
            font-size: 16px;
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            background-color: #f6efe0;
            border-radius: 10px;
        }

        .meal-ingredients i{
            padding: 1em 2em;
        }


    </style>

    <!-- il mio blocco --> 
    <div id="<?php echo $id; ?>" class="meal-loading body">
        <p class="meal-id">&nbsp;</p>
        <h2 class="meal-name">&nbsp;</h2>
        <div class="inizio">
            <img class="meal-photo" src="" alt="">
            <div>
                <div class="flex-area"><img class="mealImg" src="<?php echo 'http://wpadv.local/wp-content/plugins/wpadv-plugin/utensils.svg'; ?>" alt=""><p class="meal-area">&nbsp;</p></div>
            </div>
        </div>
        <div class="meal-ingredients"></div>
        <h5>Instructions:</h5>
        <p class="meal-instructions">&nbsp;</p>  
    </div>
    

    <script> 
        
        fetch ('https://www.themealdb.com/api/json/v1/1/search.php?f=<?php echo $meal_name; ?>')
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

            // PRENDO L'AREA
            let mealArea = document.querySelector("#<?php echo $id; ?> .flex-area .meal-area");
            mealArea.innerHTML = meal.meals[0].strArea;

            // PRENDO LA FOTO
            let mealImg = document.querySelector("#<?php echo $id; ?> .meal-photo");
            mealImg.src = meal.meals[0].strMealThumb;

            // PRENDO GLI INGREDIENTI E LE DOSI
            const ingredientsDiv = document.querySelector("#<?php echo $id; ?> .meal-ingredients");
            let allRecipeData = meal.meals[0];

            const recipeIngredients = [];

            for (var i = 1; i < 21; i++) {
                if (
                allRecipeData["strIngredient" + i] === null ||
                allRecipeData["strIngredient" + i] === ""
                ) {
                } else {
                    // FACCIO UN CONTROLLO SE NON DOVESSE ESSERCI LA DOSE (es: acqua o sale qb ecc)
                    if(allRecipeData["strMeasure" + i] === null ||
                    allRecipeData["strMeasure" + i] === ""){
                        recipeIngredients.push("<i>" + "<span>" + "q.b." + "</span>" + allRecipeData["strIngredient" + i] + "</i> <br>");
                    } else {
                        recipeIngredients.push("<i>" + "<span>" + allRecipeData["strMeasure" + i] + "</span>" + allRecipeData["strIngredient" + i] + "</i><br>");
                    }
                }
            }

            console.log(recipeIngredients);
            ingredientsDiv.innerHTML = recipeIngredients.join("");

            // PRENDO LE ISTRUZIONI
            let mealInstructions = document.querySelector("#<?php echo $id; ?> .meal-instructions");
            mealInstructions.innerHTML = meal.meals[0].strInstructions;
            

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