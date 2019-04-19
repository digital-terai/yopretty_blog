$('#fsModalSearch').on('show.bs.modal', function (e) {
    // do something...
    $('.search-input').val('')
    $('.search-result').html('');
    clearFooterResult();
})


$('.search-input').on('input',function(e){
    var input = $(this);
    var val = input.val();
    setResultPosition();
    return false;
    if (input.data("lastval") != val && val.length>2 ) {
        var content_search ="<a href=\"/search?term=\" class=\"search-string\">"+val+"</a>"
        var content ='<div class="search-item-full"><div class="search-item-img" style="width:50px">' +
            '<img src="/website/images/product.jpg" class="img-responsive">' +
            '</div>' +
            '<div class="search-item-txt"><a href="/product">401110 - coffe machine '+val+'<br>€ 30,00</a></div>' +
            '<div class="search-item-input" onclick="prevent(event);return false">' +
            '<div class="input-group"><input type="input" class="qty form-control" value="1">' +
            '<span class="input-group-btn">' +
            '<button class="btn  btn-add" data-item-id="352" data-code="401110" onclick="addToCartQuick(event,this);return false">' +
            '<i class=" fas fa-shopping-cart"></i></button>' +
            '</span>' +
            '</div></div></div>';

        $('.search-result').append(content);
        $('.searched-word').html(content_search);
        $('.searched-word-box').show();

        data = [{
            "id": "74-griglia-appoggiatazze-gr-2",
            "name": "<div class=\"search-item-short\"  ><div class=\"search-item-img\" style=\"width:50px\"><img src=\"https:\/\/nuovaricambi.net\/assets\/images\/common\/image-not-available.jpg\" class=\"img-responsive\"><\/div><div class=\"search-item-txt\" >300067 - GRIGLIA APPOGGIATAZZE GR\/2<\/div><\/div>",
            "code": "300067"
        }, {
            "id": "213-rondella-ondulata-diam-9",
            "name": "<div class=\"search-item-short\"  ><div class=\"search-item-img\" style=\"width:50px\"><img src=\"https:\/\/nuovaricambi.net\/assets\/images\/common\/image-not-available.jpg\" class=\"img-responsive\"><\/div><div class=\"search-item-txt\" >300314 - RONDELLA ONDULATA DIAM.9<\/div><\/div>",
            "code": "300314"
        }, {
            "id": "261-ghiera-livello-cromata",
            "name": "<div class=\"search-item-short\"  ><div class=\"search-item-img\" style=\"width:50px\"><img src=\"https:\/\/nuovaricambi.net\/core\/vendor\/timthumb.php?src=https:\/\/nuovaricambi.net\/media\/product\/2\/400089.jpg&w=50&h=50&zc=2&q=60\" class=\"img-responsive\" \/><\/div><div class=\"search-item-txt\" >400089 - GHIERA LIVELLO CROMATA<\/div><\/div>",
            "code": "400089"
        }, {
            "id": "426-gemma-verde-ghiera-cromata-x-fiss",
            "name": "<div class=\"search-item-short\"  ><div class=\"search-item-img\" style=\"width:50px\"><img src=\"https:\/\/nuovaricambi.net\/core\/vendor\/timthumb.php?src=https:\/\/nuovaricambi.net\/media\/product\/402629.JPG&w=50&h=50&zc=2&q=60\" class=\"img-responsive\" \/><\/div><div class=\"search-item-txt\" >402629 - GEMMA VERDE+GHIERA CROMATA X FISS.<\/div><\/div>",
            "code": "402629"
        }, {
            "id": "471-ghiera-3-8-filettata",
            "name": "<div class=\"search-item-short\"  ><div class=\"search-item-img\" style=\"width:50px\"><img src=\"https:\/\/nuovaricambi.net\/core\/vendor\/timthumb.php?src=https:\/\/nuovaricambi.net\/media\/product\/405363.jpg&w=50&h=50&zc=2&q=60\" class=\"img-responsive\" \/><\/div><div class=\"search-item-txt\" >405363 - GHIERA 3\/8 FILETTATA<\/div><\/div>",
            "code": "405363"
        }, {
            "id": "505-tubo-andata-2-gruppo-2-3-4-gruppi",
            "name": "<div class=\"search-item-short\"  ><div class=\"search-item-img\" style=\"width:50px\"><img src=\"https:\/\/nuovaricambi.net\/assets\/images\/common\/image-not-available.jpg\" class=\"img-responsive\"><\/div><div class=\"search-item-txt\" >406517 - TUBO ANDATA 2\u00b0 GRUPPO - 2\/3\/4 GRUPPI<\/div><\/div>",
            "code": "406517"
        }, {
            "id": "506-tubo-andata-1-gruppo-circ-maggiorata",
            "name": "<div class=\"search-item-short\"  ><div class=\"search-item-img\" style=\"width:50px\"><img src=\"https:\/\/nuovaricambi.net\/assets\/images\/common\/image-not-available.jpg\" class=\"img-responsive\"><\/div><div class=\"search-item-txt\" >406518 - TUBO ANDATA 1\u00b0 GRUPPO CIRC. MAGGIORATA<\/div><\/div>",
            "code": "406518"
        }, {
            "id": "507-tubo-andata-terzo-gruppo-gr3-4",
            "name": "<div class=\"search-item-short\"  ><div class=\"search-item-img\" style=\"width:50px\"><img src=\"https:\/\/nuovaricambi.net\/assets\/images\/common\/image-not-available.jpg\" class=\"img-responsive\"><\/div><div class=\"search-item-txt\" >406519 - TUBO ANDATA TERZO GRUPPO GR3\/4<\/div><\/div>",
            "code": "406519"
        }, {
            "id": "522-tubo-andata-1-2-gruppo-pf-cy",
            "name": "<div class=\"search-item-short\"  ><div class=\"search-item-img\" style=\"width:50px\"><img src=\"https:\/\/nuovaricambi.net\/assets\/images\/common\/image-not-available.jpg\" class=\"img-responsive\"><\/div><div class=\"search-item-txt\" >407185 - TUBO ANDATA 1\u00b0- 2\u00b0 GRUPPO PF \/ CY<\/div><\/div>",
            "code": "407185"
        }, {
            "id": "523-tubo-andata-3-gruppo-4-gruppi",
            "name": "<div class=\"search-item-short\"  ><div class=\"search-item-img\" style=\"width:50px\"><img src=\"https:\/\/nuovaricambi.net\/assets\/images\/common\/image-not-available.jpg\" class=\"img-responsive\"><\/div><div class=\"search-item-txt\" >407186 - TUBO ANDATA 3\u00b0 GRUPPO 4 GRUPPI<\/div><\/div>",
            "code": "407186"
        }, {
            "id": "537-tubo-andata-2-gr-super-max",
            "name": "<div class=\"search-item-short\"  ><div class=\"search-item-img\" style=\"width:50px\"><img src=\"https:\/\/nuovaricambi.net\/assets\/images\/common\/image-not-available.jpg\" class=\"img-responsive\"><\/div><div class=\"search-item-txt\" >408967 - TUBO ANDATA 2\u00b0Gr. SUPER \/ MAX<\/div><\/div>",
            "code": "408967"
        }, {
            "id": "621-chiave-di-setup-cablata",
            "name": "<div class=\"search-item-short\"  ><div class=\"search-item-img\" style=\"width:50px\"><img src=\"https:\/\/nuovaricambi.net\/assets\/images\/common\/image-not-available.jpg\" class=\"img-responsive\"><\/div><div class=\"search-item-txt\" >414916 - CHIAVE DI SETUP CABLATA<\/div><\/div>",
            "code": "414916"
        }, {
            "id": "727-volantino-rubinetto-scaldatazze",
            "name": "<div class=\"search-item-short\"  ><div class=\"search-item-img\" style=\"width:50px\"><img src=\"https:\/\/nuovaricambi.net\/core\/vendor\/timthumb.php?src=https:\/\/nuovaricambi.net\/media\/product\/460051.jpg&w=50&h=50&zc=2&q=60\" class=\"img-responsive\" \/><\/div><div class=\"search-item-txt\" >460051 - VOLANTINO RUBINETTO SCALDATAZZE<\/div><\/div>",
            "code": "460051"
        }, {
            "id": "728-rubinetto-scaldatazze-domobar",
            "name": "<div class=\"search-item-short\"  ><div class=\"search-item-img\" style=\"width:50px\"><img src=\"https:\/\/nuovaricambi.net\/core\/vendor\/timthumb.php?src=https:\/\/nuovaricambi.net\/media\/product\/460052.jpg&w=50&h=50&zc=2&q=60\" class=\"img-responsive\" \/><\/div><div class=\"search-item-txt\" >460052 - RUBINETTO SCALDATAZZE-DOMOBAR<\/div><\/div>",
            "code": "460052"
        }, {
            "id": "760-camme-cromata",
            "name": "<div class=\"search-item-short\"  ><div class=\"search-item-img\" style=\"width:50px\"><img src=\"https:\/\/nuovaricambi.net\/assets\/images\/common\/image-not-available.jpg\" class=\"img-responsive\"><\/div><div class=\"search-item-txt\" >460082 - CAMME CROMATA<\/div><\/div>",
            "code": "460082"
        }, {
            "id": "771-bussola-per-lancia-snodata",
            "name": "<div class=\"search-item-short\"  ><div class=\"search-item-img\" style=\"width:50px\"><img src=\"https:\/\/nuovaricambi.net\/core\/vendor\/timthumb.php?src=https:\/\/nuovaricambi.net\/media\/product\/460091.jpg&w=50&h=50&zc=2&q=60\" class=\"img-responsive\" \/><\/div><div class=\"search-item-txt\" >460091 - BUSSOLA PER LANCIA SNODATA<\/div><\/div>",
            "code": "460091"
        }, {
            "id": "890-boccola-filettata-mini",
            "name": "<div class=\"search-item-short\"  ><div class=\"search-item-img\" style=\"width:50px\"><img src=\"https:\/\/nuovaricambi.net\/assets\/images\/common\/image-not-available.jpg\" class=\"img-responsive\"><\/div><div class=\"search-item-txt\" >503512 - BOCCOLA FILETTATA MINI<\/div><\/div>",
            "code": "503512"
        }, {
            "id": "10644-manopolina-regolaz-x-stella-maggiorata",
            "name": "<div class=\"search-item-short\"  ><div class=\"search-item-img\" style=\"width:50px\"><img src=\"https:\/\/nuovaricambi.net\/assets\/images\/common\/image-not-available.jpg\" class=\"img-responsive\"><\/div><div class=\"search-item-txt\" >503563 - MANOPOLINA REGOLAZ. X STELLA MAGGIORATA<\/div><\/div>",
            "code": "503563"
        }, {
            "id": "10645-settore-copriforo-stella-maggiorata",
            "name": "<div class=\"search-item-short\"  ><div class=\"search-item-img\" style=\"width:50px\"><img src=\"https:\/\/nuovaricambi.net\/assets\/images\/common\/image-not-available.jpg\" class=\"img-responsive\"><\/div><div class=\"search-item-txt\" >503564 - SETTORE COPRIFORO STELLA MAGGIORATA<\/div><\/div>",
            "code": "503564"
        }, {
            "id": "10646-stella-femmina-maggiorata",
            "name": "<div class=\"search-item-short\"  ><div class=\"search-item-img\" style=\"width:50px\"><img src=\"https:\/\/nuovaricambi.net\/assets\/images\/common\/image-not-available.jpg\" class=\"img-responsive\"><\/div><div class=\"search-item-txt\" >503565 - STELLA FEMMINA MAGGIORATA<\/div><\/div>",
            "code": "503565"
        }, {
            "id": "997-manopola-rubinetto-scaldatazze",
            "name": "<div class=\"search-item-short\"  ><div class=\"search-item-img\" style=\"width:50px\"><img src=\"https:\/\/nuovaricambi.net\/core\/vendor\/timthumb.php?src=https:\/\/nuovaricambi.net\/media\/product\/516779.jpg&w=50&h=50&zc=2&q=60\" class=\"img-responsive\" \/><\/div><div class=\"search-item-txt\" >516779 - MANOPOLA RUBINETTO SCALDATAZZE<\/div><\/div>",
            "code": "516779"
        }, {
            "id": "1000-guarnizione-maggiorata-tappo",
            "name": "<div class=\"search-item-short\"  ><div class=\"search-item-img\" style=\"width:50px\"><img src=\"https:\/\/nuovaricambi.net\/assets\/images\/common\/image-not-available.jpg\" class=\"img-responsive\"><\/div><div class=\"search-item-txt\" >517716 - GUARNIZIONE MAGGIORATA TAPPO<\/div><\/div>",
            "code": "517716"
        }, {
            "id": "1075-ghiera-3-8-cromata",
            "name": "<div class=\"search-item-short\"  ><div class=\"search-item-img\" style=\"width:50px\"><img src=\"https:\/\/nuovaricambi.net\/core\/vendor\/timthumb.php?src=https:\/\/nuovaricambi.net\/media\/product\/522127_C.jpg&w=50&h=50&zc=2&q=60\" class=\"img-responsive\" \/><\/div><div class=\"search-item-txt\" >522127\/C - GHIERA 3\/8 CROMATA<\/div><\/div>",
            "code": "522127\/C"
        }, {
            "id": "1077-bussola-3-8-prolungata",
            "name": "<div class=\"search-item-short\"  ><div class=\"search-item-img\" style=\"width:50px\"><img src=\"https:\/\/nuovaricambi.net\/core\/vendor\/timthumb.php?src=https:\/\/nuovaricambi.net\/media\/product\/522129.JPG&w=50&h=50&zc=2&q=60\" class=\"img-responsive\" \/><\/div><div class=\"search-item-txt\" >522129 - BUSSOLA 3\/8 PROLUNGATA<\/div><\/div>",
            "code": "522129"
        }, {
            "id": "1078-bussola-1-2-prolungata",
            "name": "<div class=\"search-item-short\"  ><div class=\"search-item-img\" style=\"width:50px\"><img src=\"https:\/\/nuovaricambi.net\/core\/vendor\/timthumb.php?src=https:\/\/nuovaricambi.net\/media\/product\/522130.jpg&w=50&h=50&zc=2&q=60\" class=\"img-responsive\" \/><\/div><div class=\"search-item-txt\" >522130 - BUSSOLA 1\/2 PROLUNGATA<\/div><\/div>",
            "code": "522130"
        }];

        $.each( data, function( i, item ) {
            console.log(item.id);
        });            }
    if(val.length<3) {
        clearFooterResult()
    }
});

$( window ).resize(function() {
    setResultPosition()
});

function setResultPosition(){
    var pos= $('.search-input').position();
    var parentWidth = $('.search-input').width()+35;

    $('.search-result').css({left: pos.left-50,width:parentWidth  });
}

function clearFooterResult(){
    $('.searched-word-box').hide();
    $('.searched-word').html('');
}