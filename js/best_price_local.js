javascript: (function() {
    unsetcookie = function (key) {
        return document.cookie = key + '=;expires=Thu, 01 Jan 1970 00:00:01 GMT;';
    };

    setCookie = function(key, value, time_expire = 31536000000){
        if (value==undefined || value === undefined || value == '') {
            keyValue = document.cookie.match("(^|;) ?" + key + "=([^;]*)(;|$)");
            if (keyValue) {
                return keyValue[2];
            }
            else {
                return undefined;
            }
            return false;
        }
        else{
            expires = new Date();
            expires.setTime(expires.getTime() + time_expire);
            cookie = key + "=" + value + ";expires=" + expires.toUTCString();
            return document.cookie = cookie;    
        }
    };

    best = false;
    best_element = $('tr');
    my_pre_bank = (!setCookie('pre_bank_localbitcoin')) ? 'banesco' : setCookie('pre_bank_localbitcoin');
    bank_list_ = prompt('¿Que bancos Buscas? (Separar con una coma)',my_pre_bank);
    if (!bank_list_||bank_list_.trim().length<1) {return false;};
    bank_list_ = bank_list_.toLowerCase().split(',');

    my_pre_balance = (!setCookie('balance_btc_localbitcoin')) ? '0' : setCookie('balance_btc_localbitcoin');
    my_balance = prompt('Indica tu saldo en BTC', my_pre_balance);
    $('tr.clickable').each(function(index, el) {
        ads = {
            user: $(this).find('td.column-user'),
            type:$(this).find('.column-button').text().trim().toLowerCase(),
            bank: $(this).find('td.column-user').next('td').html().trim().replace(/ /gi,''),
            price: $(this).find('td.column-price').html().trim().replace(/\D/g, '').substr(0, (($(this).find('td.column-price').html().trim().replace(/\D/g, '').length * 1) - 2 * 1)),
            limit: $(this).find('td.column-limit').html().trim(),
            limits: {
                minimo: 0,
                maximo: 999999999999999999999999999
            }
        };
        ads.type = (ads.type=='sell'||ads.type=='vender') ? 'sell' : 'buy';
        best = (ads.type=='sell'&&!best) ? 0 : best;
        best = (ads.type=='buy'&&!best) ? 999999999999999999999999999999 : best;
        best = (!best) ? 0 : best;

        i_have_vef = my_balance.toLowerCase().trim().replace(/ /gi,'').indexOf('vef')>0 ? parseInt(my_balance.replace(/\D/g, '')) : ((my_balance * 1) * (ads.price * 1));
        if (ads.limit.indexOf('-') >= 0 && ads.limit.indexOf('maximo') < 0 && ads.limit.indexOf('minimo') < 0) {
            ads.limit = ads.limit.split('-');
            ads.limits.maximo = parseInt(ads.limit[1].trim().replace(/\D/g, ''));
            ads.limits.minimo = parseInt(ads.limit[0].trim().replace(/\D/g, ''));
        }
        else if (ads.limit.indexOf('maximo')) {
            ads.limits.action = 'Como Maximo';
            ads.limits.minimo = parseInt(((0.0001 * 1) * (ads.price)));
            ads.limits.maximo = parseInt(ads.limit.trim().replace(/\D/g, ''));
        }
        else if (ads.limit.indexOf('minimo')) {
            ads.limits.action = 'Como minimo';
            ads.limits.minimo = parseInt(ads.limit.trim().replace(/\D/g, ''));
            ads.limits.maximo = parseInt(((my_balance * 1) * (ads.price)));
        }
        if (i_have_vef <= ads.limits.maximo && i_have_vef >= ads.limits.minimo) {
            search_bank_ = (ads.bank.trim().toLowerCase().indexOf(bank_list_) >= 0);
            if (ads.type=='sell' && i_have_vef > best && (search_bank_)) {
                best = i_have_vef;
                best_element = $(this);
            }
            else if (ads.type=='buy' && i_have_vef < best && (search_bank_)) {
                best = i_have_vef;
                best_element = $(this);
            }
        }
    });
    $('tr.clickable').not(best_element).hide();
})()




