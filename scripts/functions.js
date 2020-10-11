const GET = () => {
  let list = {};
  window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, (m, key, value) => {
    list[key] = value;
  });

  return list;
};

