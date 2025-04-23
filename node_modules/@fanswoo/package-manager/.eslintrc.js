const path = require('path');

module.exports = {
  extends: ['@fanswoo/workspace'],
  settings: {
    'import/resolver': {
      alias: {
        map: [['@', path.join(__dirname, './src')]],
        paths: ['./src/'],
        extensions: ['.js', '.jsx', '.ts', '.tsx', '.vue'],
        moduleDirectory: ['node_modules'],
      },
    },
  },
};
