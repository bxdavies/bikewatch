userColumns = [
    new Option('First Name', 'first_name'),
    new Option('Last Name', 'last_name'),
    new Option('Date of Birth', 'dob'),
    new Option('Address Line 1', 'address_line_1'),
    new Option('Postcode', 'postcode'),
    new Option('Mobile Phone Number', 'mobile_number'),
    new Option('Email Address', 'email_address')
]

bikeColumns = [
    new Option('Nickname', 'nickname'),
    new Option('MPN', 'mpn'),
    new Option('Brand', 'brand'),
    new Option('Model', 'model'),
    new Option('Gender', 'gender'),
    new Option('Age', 'age'),
]


document.getElementById('table').addEventListener('change', (event) => {
    var column = document.getElementById("column")

    removeChildren(column)
    
    if (event.target.value == ''){
        var defaultOption = document.createElement("option")
        defaultOption.value = ''
        defaultOption.innerHTML = "Please select what you want to search"
        column.append(defaultOption)
    }
    else if (event.target.value == 'user'){
        userColumns.forEach(element => {
            column.append(element)
        });

    }
    else if (event.target.value == 'bike'){
        bikeColumns.forEach(element => {
            column.append(element)
        });
    }
})

function removeChildren(element){
    while (element.firstChild){
        element.firstChild.remove();
    }
}

// Stolen from http://jsfiddle.net/brandonscript/1wz8a2td/
function hyphensToCamelCase(str) {
    var arr = str.split(/[_-]/);
    var newStr = "";
    for (var i = 1; i < arr.length; i++) {
        newStr += arr[i].charAt(0).toUpperCase() + arr[i].slice(1);
    }
    return arr[0] + newStr;
}

// Stolen from https://stackoverflow.com/questions/21792367/replace-underscores-with-spaces-and-capitalize-words
function humanize(str) {
    var i, frags = str.split('_');
    for (i=0; i<frags.length; i++) {
      frags[i] = frags[i].charAt(0).toUpperCase() + frags[i].slice(1);
    }
    return frags.join(' ');
  }

document.getElementById('column').addEventListener('change', (event) => {
    var values = $('#column').val();
    var inputs = document.getElementById('inputs');

    removeChildren(inputs);
    values.forEach(value => {
        
        var input = document.createElement('input');
        var label = document.createElement('label');

        label.for = hyphensToCamelCase(value);
        label.innerHTML = humanize(value);

        input.type = 'text';
        input.id = hyphensToCamelCase(value);
        input.name = hyphensToCamelCase(value);


        if (value == 'dob'){
            var html = `
                <h4> Date of birth  </h4>
                <div class="hint"> Day Month Year </div>
                <div class="dob">
                    <div>
                        <label for="DOBDay"> Day </label>
                        <input id="DOBDay" name="DOBDay" type="number" placeholder="24" min="1" max="31" size="2" style="width: 2.5em;" required>
                    </div>

                    <div> 
                        <label for="DOBMonth"> Month </label>
                        <input id="DOBMonth" name="DOBMonth"type="number" placeholder="12" min="1" max="12" size="2" style="width: 2.5em;" required>
                    </div>

                    
                    <div>
                        <label for="DOBYear"> Year  </label>
                        <input id="DOBYear" name="DOBYear" type="number" placeholder="2018" size="4" style="width: 4em;" required>
                    </div>
                </div>
            `;

            inputs.innerHTML+= html;
            return;
            
        }
        else if (value == 'mobile_number'){
            input.placeholder="07700 900000";
            input.type = 'tel';
        }
        else if (value == 'email_address'){
            input.placeholder = "john.doe@example.com";
            input.type = 'email';
        }
        else if (value == 'age'){
            var html = `
                <label for="age"> Age </label>
                <select name="age" id="age">
                    <option> 3-4 </option>
                    <option> 5-6 </option>
                    <option> 7-8 </option>
                    <option> 9-10 </option>
                    <option> 11-12 </option>
                    <option selected> Adult </option>
                </select>
            `

            inputs.innerHTML+= html;
            return;
        }
        else if (value == 'gender'){
            var html = `
                <label for="gender"> Gender </label>
                <select name="gender" id="gender">
                    <option selected> Unisex </option>
                    <option> Male </option>
                    <option> Female </option>
                </select>
            `

            inputs.innerHTML+= html;
            return;
        }

        inputs.append(label);
        inputs.append(input);

    })


})

document.getElementById('esearch').addEventListener('click', () => {
    const id = document.getElementById('id').value;
    const table = document.getElementById('etable').value;
    const request = $.post("search_dao.php", {action: 'esearch', table: table, id: id})
    var url;

    request.done((response) => {
        if(table == 'user'){
            url = `../view/view.php?type=user&id=${id}`;
        }
        else if (table == 'bike'){
            url = `../view/view.php?type=bike&id=${id}`;
        }
        if(table == 'crime'){
            url = `../view/view.php?type=crime&id=${id}`;
        }
        
        createAlert('success', 'Result found, you will be redirected!', url)
    });

    request.fail((response) => {
        createAlert('error', `${id} does not exist in the ${table} table!`)
    })
})