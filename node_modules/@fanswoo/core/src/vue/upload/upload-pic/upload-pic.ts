const uploadPics = async (
  files,
  options: {
    relatedPicName: string;
    postMaxSize: number;
    uploadMaxSize: number;
  } = {
    relatedPicName: '',
    postMaxSize: 0,
    uploadMaxSize: 0,
  },
) => {
  if (files.length === 0) {
    return;
  }

  const { relatedPicName, postMaxSize, uploadMaxSize } = options;
  let sizeTotal = 0;
  for (let i = 0; i < files.length; i++) {
    sizeTotal = sizeTotal + files[i].size;
  }
  if (
    (postMaxSize > 0 && sizeTotal > postMaxSize) ||
    (uploadMaxSize > 0 && sizeTotal > uploadMaxSize)
  ) {
    const response = {
      data: {
        status: 'error',
        message: '',
      },
    };
    response.data.message = '最大同時上傳限制超過' + postMaxSize / 1024 / 1024 + 'M';
    return response.data;
  }

  let params = new FormData();
  for (let i = 0; i < files.length; i++) {
    params.append('files[]', files[i]);
  }

  if (relatedPicName) {
    params.append('relatedPicName', relatedPicName);
  }
  params.append('_token', <any>$('meta[name="csrf-token"]').attr('content'));
  
  let response;
  try {
    response = await axios.post(
      window.location.origin + '/api/pic/upload',
      params,
      {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
      },
    );
  } catch (error) {
    console.error(error);
    response.data.message = '圖片格式錯誤';
  }

  return response.data;
};

export default { uploadPics };
export { uploadPics };
