BX.ready(function () {

  let arr = document.querySelectorAll("a[class = prideField]");
  if (arr){
    for (i = 0; i < arr.length; i++)
    {
      BX.bind(arr[i], "click", addNote);  
    }
  }    

  let arr2 = document.querySelectorAll("span[class = prideField]");
  if (arr2){
    for (i = 0; i < arr2.length; i++)
    {
      BX.bind(arr2[i], "click", deleteNote);  
    }
  }    
});

let ob = {
    'target': ''
};
  
  function addNote (e) {
    ob.target = e.target;
    popupAdd();
  }

  function deleteNote (e) {
    let elem = e.target.getAttribute("data-elem");
    let iblock = e.target.getAttribute("data-iblock");
    let user = e.target.getAttribute("data-user");
    let id = e.target.getAttribute("data-id");

    fetch("https://ca43694.tw1.ru/rest/1/64j22tytcv13z589/lists.element.delete.json?IBLOCK_TYPE_ID=lists&IBLOCK_ID=36&ELEMENT_CODE="+id);
    e.target.style = "display:none";
  
    let object = BX.create({
      tag: 'a',
      attrs: {'data-elem': elem, 'data-iblock': iblock, 'data-user': user,},
      style: {"font-size":"30px", "text-decoration": "none", "color":"gray", "cursor":"pointer"},
      text: '★',
  });
    BX.append(object, e.target.parentElement);
    BX.bind(object, "click", addNote);
    BX.remove(e.target);
  }

    function popupAdd () {
  var popup = BX.PopupWindowManager.create("popup-message", null, {
      content: '<div style="width:100%;"><textarea id="desc" placeholder="Добавьте описание" style="padding:4px 5px;width:90%;height:150px;"></textarea></div>',
      width: 400, // ширина окна
      height: 350, // высота окна
      zIndex: 100, // z-index
      closeIcon: {
          // объект со стилями для иконки закрытия, при null - иконки не будет
          opacity: 1
      },
      titleBar: "Добавить в Избранное",
      closeByEsc: true, // закрытие окна по esc
      darkMode: false, // окно будет светлым или темным
      autoHide: false, // закрытие при клике вне окна
      draggable: true, // можно двигать или нет
      resizable: true, // можно ресайзить
      min_height: 350, // минимальная высота окна
      min_width: 400, // минимальная ширина окна
      lightShadow: true, // использовать светлую тень у окна
      angle: false, // появится уголок
      overlay: {
          // объект со стилями фона
          backgroundColor: "black",
          opacity: 500
      }, 
      buttons: [
          new BX.PopupWindowButton({
              text: "Добавить", // текст кнопки
              id: "save-btn", // идентификатор
              className: "ui-btn ui-btn-success", // доп. классы
              events: {
                click: function() {
                  let date = new Date().getTime();
                  let elem = ob.target.getAttribute("data-elem");
                  let iblock = ob.target.getAttribute("data-iblock");
                  let user = ob.target.getAttribute("data-user");

                  fetch("https://ca43694.tw1.ru/rest/1/64j22tytcv13z589/lists.element.add.json?IBLOCK_TYPE_ID=lists&IBLOCK_ID=36&ELEMENT_CODE="+date+"&fields[NAME]=заметка&fields[PROPERTY_111]="+elem+"&fields[PROPERTY_112]="+iblock+"&fields[PROPERTY_113]="+BX("desc").value+"&fields[PROPERTY_114]="+user);
                  ob.target.style = "display:none";

                  let object = BX.create({
                    tag: 'span',
                    attrs: {'data-elem': elem, 'data-iblock': iblock, 'data-user': user, 'data-id': date},
                    style: {"font-size":"30px", "text-decoration": "none", "color":"rgb(247 214 89)", "cursor":"pointer"},
                    text: '★',
                });
                  BX.append(object, ob.target.parentElement);
                  BX.bind(object, "click", deleteNote);
                  BX.remove(ob.target);
                  BX("desc").value = '';
                  popup.close();
                }
              }
          }),
          new BX.PopupWindowButton({
              text: "Закрыть",
              id: "copy-btn",
              className: "ui-btn ui-btn-primary",
              events: {
                click: function() {
                    BX("desc").value = '';
                    popup.close();
                }
              }
          })
      ],
      events: {
         onPopupShow: function() {
            // Событие при показе окна
         },
         onPopupClose: function() {
            // Событие при закрытии окна                
         }
      }
  });
  popup.show();
}