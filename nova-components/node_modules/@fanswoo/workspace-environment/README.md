# `@fanswoo/workspace-environment`

## 介紹

本套件是 `TypeScript` + `Vue` + `Jest` + `Prettier` 的環境設定檔，讓使用者僅需套用此套件即可快速完成複雜的環境設置。

## 使用方法

### TypeScript 使用方法

直接於專案根目錄設置 `.tsconfig.json` 並引用 `extends` 屬性即可，若對於錯誤訊息有特殊需求，可以再根據需要覆寫需要的設定。

```
{
  "extends": "@fanswoo/workspace-environment/tsconfig.default.json",
  "compilerOptions": {
    "outDir": "public",
    "baseUrl": ".",
    "typeRoots": [
      "./node_modules/@types",
    ],
    "paths": {
      "@/*": [
        "./resources/js/*"
      ],
    }
  },
  "include": [
    "./node_modules/**/*.d.ts"
  ]
}
```

### Jest 使用方法

直接於專案根目錄設置 `jest.conf.js` 即可。

```
module.exports = {
  verbose: true,
  moduleFileExtensions: ['js', 'ts', 'json', 'vue'],
  transform: {
    '.*\\.(vue)$': 'vue-jest',
    '^.+\\.tsx?$': 'ts-jest',
    '^.+\\.js$': 'babel-jest',
  },
  testURL: 'http://localhost/',
  snapshotSerializers: ['jest-serializer-vue'],
  moduleNameMapper: {
    '^@/(.*)$': '<rootDir>/resources/js/$1',
  },
};
```

### Prettier & Prettier PHP 使用方法

直接於專案根目錄設置 `.prettierrc.js` 即可，將會自動排版包含 JavaScript、TypeScript、PHP、CSS、JSON 等檔案。

```
module.exports = {
  singleQuote: true,
  trailingComma: 'all',
  phpVersion: '7.4',
  braceStyle: 'psr-2',
};
```

使用 Prettier 需要配合支援 Prettier 的編輯器，並應根據編輯器設定作設置調整，例如若使用 VSCode 作為編輯器，則應於 `.vscode/setting.json` 檔案進行如下設置：

```
{
  "files.autoSave": "onWindowChange",
  "editor.formatOnSave": true,
  "vetur.validation.template": false,
  "[json]": {
    "editor.defaultFormatter": "esbenp.prettier-vscode"
  },
  "[scss]": {
    "editor.defaultFormatter": "esbenp.prettier-vscode"
  },
  "[vue]": {
    "editor.defaultFormatter": "esbenp.prettier-vscode"
  },
  "[javascript]": {
    "editor.defaultFormatter": "esbenp.prettier-vscode"
  },
  "[typescript]": {
    "editor.defaultFormatter": "esbenp.prettier-vscode"
  },
  "[php]": {
    "editor.defaultFormatter": "esbenp.prettier-vscode"
  }
}
```

> 若有需要略過排版的檔案，可以使用 `.prettierignore` 檔案作為略過檔案的規則設置，其設置規則與 .gitignore 相同。

---

> ### 補充說明
> 更多使用方式請參考 [fanswoo-framework 使用教程](https://fanswoo.atlassian.net/wiki/spaces/fanswooDevelopers)