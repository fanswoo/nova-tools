const assign = (object, source) => {
  const assignedObject = object;
  Object.keys(source).forEach((key) => {
    if (
      Object.prototype.hasOwnProperty.call(assignedObject, key)
      // && typeof assignedObject[key] === typeof source[key]
    ) {
      assignedObject[key] = source[key];
    }
  });
};

const isEmpty = (value: any) => {
  if (value === null || value === undefined) {
    return true;
  }

  if (typeof value === 'string' && value === '') {
    return true;
  }

  if (typeof value === 'number' && value === 0) {
    return true;
  }

  if (Array.isArray(value) && value.length === 0) {
    return true;
  }

  return false;
};

const generateRandomString = (num: number) => {
  let result = '';
  const characters =
    'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
  const charactersLength = characters.length;
  for (let i = 0; i < num; i += 1) {
    result += characters.charAt(Math.floor(Math.random() * charactersLength));
  }

  return result;

  // const random = Math.random().toString(36).substring(0, num);
  // return random;
};

const getTransform = (element) => {
  let transform;

  if (element.currentStyle) {
    transform = element.currentStyle.transform;
  } else {
    transform = getComputedStyle(element, null).transform;
  }

  const transformArray = transform.slice(7, transform.length - 1).split(', ');

  if (transformArray.length === 6) {
    return {
      scaleX: parseInt(transformArray[0], 10),
      skewY: parseInt(transformArray[1], 10),
      skewX: parseInt(transformArray[2], 10),
      scaleY: parseInt(transformArray[3], 10),
      translateX: parseInt(transformArray[4], 10),
      translateY: parseInt(transformArray[5], 10),
    };
  }

  return {
    scaleX: null,
    skewY: null,
    skewX: null,
    scaleY: null,
    translateX: null,
    translateY: null,
  };
};

export { assign, isEmpty, generateRandomString, getTransform };
