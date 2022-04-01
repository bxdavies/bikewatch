// Convert Hexcode to colour name
var colourInput = document.getElementById('colour');
colourInput.onchange = () => {

    var nameThatColorMatch = ntc.name(colourInput.value);
    colourInput.value = nameThatColorMatch[1];
}