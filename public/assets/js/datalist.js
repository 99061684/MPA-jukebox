// document.getElementById('inputStates').addEventListener('input', function(e) {
//     var input = e.target;
//     var list = document.getElementById('listStates');
//     var options = list.querySelectorAll('option');
//     var value = input.value;
//     var regex = new RegExp(value, 'i');
//     var found = false;
//     for (var i = 0; i < options.length; i++) {
//         var option = options[i];
//         if (regex.test(option.value)) {
//             option.style.display = '';
//             found = true;
//         } else {
//             option.style.display = 'none';
//         }
//     }
//     if (!found) {
//         list.style.display = 'none';
//     } else {
//         list.style.display = '';
//     }
// });

// const input = document.getElementById('songDatalistInput');
// const datalist = document.getElementById('songDatalist');
// const statesHidden = document.getElementById('SelectedSongs');
// const TextIdInput = "songOption";
// const separator = ',';
// if (datalist !== null) {
//     var options = datalist.options;
// } else {
//     var options = null;
// }
// var optionsarray = jQuery.map(options ,function(option) {
//     return {"value":option.value, "id":option.id};
// });

// if (input !== null && datalist !== null && options !== null && statesHidden !== null) {
//     input.addEventListener('input', function(e) {
//         statesHidden.value = "";
//         var value = e.target.value.split(separator);
//         value = value.map(function(item) {
//             item = item.toLowerCase();
//             item = item.trim();
//             item = item.replace(/^\/|\/$/g, '');
//             return item;
//         });
//         for (let i = 0; i < options.length; i++) {
//             // console.log(value);
//             // console.log(options[i].value.toLowerCase());
//             if (value.includes(options[i].value.toLowerCase()) || value.join(", ").includes(options[i].value.toLowerCase())) {
//                 var Songid = options[i].id.split(TextIdInput)[1];
//                 if (statesHidden.value.length > 0) {
//                     statesHidden.value = statesHidden.value + "," + Songid;
//                 } else {
//                     statesHidden.value = Songid;
//                 }

//                 var str = options[i].value;
//                 filldatalist(str);
//             }
//         }
//     });
// }

// function filldatalist(prefix) {
//     // if (input.value().indexOf(separator) > -1 && options.length > 0) {
//     if (options.length > 0) {

//         // get the optionsarray id's where the value == prefix or prefix is a substring of muliple options
//         let optionsarray2 = jQuery.map(options ,function(option) {
//             return {"value":option.value, "id":option.id};
//         });
//         console.log(optionsarray2);
//         let optionsarray3 = optionsarray2.filter(function(item) {
//             console.log(item.value.toLowerCase());
//             console.log(prefix.toLowerCase());
//             console.log(item.value.toLowerCase() === prefix.toLowerCase());
//             return item.value.toLowerCase() === prefix.toLowerCase();
//         });
//         console.log(optionsarray3);
//         datalist.innerHTML = "";

//         // var optionsarrayid = optionsarray.findIndex(function(item) {
//         //     console.log(item.value.toLowerCase());
//         //     console.log(prefix.toLowerCase());

//         //     return prefix.toLowerCase().includes(item.value.toLowerCase());
//         //     return item.value.toLowerCase() === prefix.toLowerCase();
//         // }) + 1;
//         for (let j=0; j < optionsarray2.length; j++ ) {
//             if (optionsarray2[j].value.toLowerCase() !== prefix.toLowerCase()) {
//                 var option = document.createElement('option');
//                 option.value = prefix+", "+optionsarray2[j]["value"];

//                 option.id = optionsarray3[0].id+separator+ optionsarray2[j]["id"];
//                 datalist.appendChild(option);
//             }
//         }
//     }
// }

// var datalist = jQuery('datalist');
// var options = jQuery('datalist option');
// var optionsarray = jQuery.map(options, function(option) {
//         return option.value;
// });
// var input = jQuery('input[list]');
// var inputcommas = (input.val().match(/,/g)||[]).length;
// var separator = ',';

// function filldatalist(prefix) {
//     if (input.val().indexOf(separator) > -1 && options.length > 0) {
//         datalist.empty();
//         for (i=0; i < optionsarray.length; i++ ) {
//             if (prefix.indexOf(optionsarray[i]) < 0 ) {
//                 datalist.append('<option value="'+prefix+optionsarray[i]+'">');
//             }
//         }
//     }
// }
// input.bind("change paste keyup",function() {
//     var inputtrim = input.val().replace(/^\s+|\s+$/g, "");
//   //console.log(inputtrim);
//     var currentcommas = (input.val().match(/,/g)||[]).length;
//   //console.log(currentcommas);
//     if (inputtrim != input.val()) {
//         if (inputcommas != currentcommas) {
//             var lsIndex = inputtrim.lastIndexOf(separator);
//             var str = (lsIndex != -1) ? inputtrim.substr(0, lsIndex)+", " : "";
//             filldatalist(str);
//             inputcommas = currentcommas;
//         }
//         input.val(inputtrim);
//     }
// });

// $('#inputStates').change(function(){
//     var c =  $('#inputStates').val();
//     $('#inputStates').val(getTextValue());
//     $('#statesHidden').val(c);
// });

// function getTextValue(){
//   var val =  $('#inputStates').val();
//   var states = $('#states');
//   var endVal = $(states).find('option[value="' + val + '"]');
//   //depending on your logic, if endVal is empty it means the value wasn't found in the datalist, you can take some action here
//   return endVal.text();
// }
