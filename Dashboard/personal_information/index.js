document.getElementById("submit").onclick = () => {
  for (let i = 0; i <= 56; i++) {
    const element = document.getElementById(`field_${i}`);
    console.log(element.value);
  }
};
