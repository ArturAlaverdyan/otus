BX.ready(function () {
    let link = BX.findChild(BX("copyright"), {tag: 'a', className: 'footer-link'}, true);
    BX.style(link, 'display', 'none');
    let newLink = BX.create({
        tag: 'a',
        props: {'className': 'footer-link', 'target':'_blank', 'href':'https://help.pochtavip.com/G2sCdf43ddSx/'},
        text: 'Техническая поддержка',
    });
    BX.append(newLink, BX("copyright"));
});
