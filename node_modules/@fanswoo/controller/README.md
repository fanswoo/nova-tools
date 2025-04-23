# `@fanswoo/controller`

## 介紹

本套件用途是讓網頁可以透過單一進入點進行控制，避免一個網頁擁有多支 javascript 檔案，因此應使用 Controller 類別作為進入點，並使用 Middleware 作為中間件。

---

## 使用方法

### Controller 類別

Controller 類別應作為管理一個頁面的唯一 javascript 檔案。

```
import { Controller } from '@fanswoo/controller/main';
import { middlewares } from '@fanswoo/core/main';

global.Controller = new (class MainController extends Controller {
  constructor() {
    super({
      middlewares: [
        middlewares.ControlCenterMiddleware, 
        middlewares.WebMiddleware
      ],
    });
  }

  ready() {}
})();

```

### Middleware 類別

Middleware 類別是讓 Controller 載入套件使用。

```
import { Middleware } from '@fanswoo/controller/main';

export default class UserMiddleware extends Middleware {
  public handle(): void {
    // do something ...
  }
}

```

---


> ### 補充說明
> 更多使用方式請參考 [fanswoo-framework 使用教程](https://fanswoo.atlassian.net/wiki/spaces/fanswooDevelopers)