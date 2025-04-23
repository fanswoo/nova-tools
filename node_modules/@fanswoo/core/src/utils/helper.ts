import 'jquery';

export default class ff {
  // 檢查XXX，如果XXX已經變化就執行XXX的函式
  static delayExecute(check, proc, chkInterval) {
    // default interval = 500ms
    const x = chkInterval || 500;
    const hnd = window.setInterval(() => {
      // if check() return true,
      // stop timer and execute proc()
      if (check()) {
        window.clearInterval(hnd);
        return proc();
      }
      return false;
    }, x);
  }

  static isJson(str) {
    if (typeof str === 'object') {
      return true;
    }

    try {
      JSON.parse(str);
    } catch (e) {
      return false;
    }

    return true;
  }

  static async sleep(ms) {
    return new Promise((resolve) => setTimeout(resolve, ms));
  }

  static inputValueToWidth(value: string) {
    let width = 36;

    for (let i = 0; i < value.length; i += 1) {
      if (
        value.charCodeAt(i) < 0x4e00 ||
        value.charCodeAt(i) > 0x9fa5
      ) {
        // 數字的寬度
        if (typeof value[i] === 'number') {
          width += 5;
        } else {
          width += 7;
        }
      } else {
        width += 11.95;
      }
    }
    return width;
  }
}
