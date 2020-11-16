export const GET = () => {
  let list = {};
  window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, (m, key, value) => {
    list[key] = value;
  });

  return list;
};

export const empty = (value) => {
  if(value === null || value === undefined || value === "")
    return true;
  else
    return false;
}