class ProfileMenu {

  constructor(eventTriggeringElement, menuDivObject) {
    this.button = eventTriggeringElement;
    this.menuBlock = menuDivObject;
    this.menu_state = false;
    this.openPanel = null;
    this.closePanel = null;

    this.button.addEventListener('click', this._menuEvent);

    this.openPanel =  () => {
      anime({
        targets: this.menuBlock,
        translateX: -400,
        easing: 'easeOutElastic(1, .6)',
        duration: 750
      });
      this.menu_state = true;
    }
    
    this.closePanel = () => {
      anime({
        targets: this.menuBlock,
        translateX: 0,
        easing: 'easeOutElastic(1, .6)',
        duration: 750
      });
      this.menu_state = false;
    }

  }

  _menuEvent = () => {
    if (!this.menu_state) {
      this.openPanel();

    } else if (this.menu_state) {
      this.closePanel();

    }
  }
}


class UploadMenu extends ProfileMenu {

  openPanel = () => {
    anime({
      targets: this.menuBlock,
      translateY: 400,
      easing: 'easeOutElastic(1, .6)',
      duration: 750
    });
    this.menu_state = true;
  }

  closePanel = () => {
    anime({
      targets: this.menuBlock,
      translateY: 0,
      easing: 'easeOutElastic(1, .6)',
      duration: 750
    });
    this.menu_state = false;
  }
}


export {ProfileMenu, UploadMenu};