<script src="https://unpkg.com/dayjs@1.8.21/dayjs.min.js"></script>
<script>

const data1 = dayjs(1671030000000);
const data2 = dayjs(1670425200000);

console.log(data1.diff(data2, "day"));
// const date1 = dayjs("2022-12-01 12:30:25.123");
// const date2 = dayjs("2021-10-24 13:23:50.456");

// date1.format("YYYY-MM-DD HH:mm:ss.SSS"); // 2022-12-01 12:30:25.123
// date2.format("YYYY-MM-DD HH:mm:ss.SSS"); // 2021-10-24 13:23:50.456

// date1.diff(date2); // 34815994667

// date1.diff(date2, "year"); // 1
// date1.diff(date2, "y"); // 1
// date1.diff(date2, "y", true); // 1.1047389818237257

// date1.diff(date2, "month"); // 13
// date1.diff(date2, "M"); // 13
// date1.diff(date2, "M", true); // 13.256867781884708

// date1.diff(date2, "week"); // 57
// date1.diff(date2, "w"); // 57
// date1.diff(date2, "w", true); // 57.566128748346564

// date1.diff(date2, "day"); // 402
// date1.diff(date2, "d"); // 402
// date1.diff(date2, "d", true); // 402.9629012384259

// date1.diff(date2, "hour"); // 9671
// date1.diff(date2, "h"); // 9671
// date1.diff(date2, "h", true); // 9671.109629722223

// date1.diff(date2, "minute"); // 580266
// date1.diff(date2, "m"); // 580266
// date1.diff(date2, "m", true); // 580266.5777833334

// date1.diff(date2, "second"); // 34815994
// date1.diff(date2, "s"); // 34815994
// date1.diff(date2, "s", true); // 34815994.667

// date1.diff(date2, "millisecond"); // 34815994667
// date1.diff(date2, "ms"); // 34815994667
// date1.diff(date2, "ms", true); // 34815994667
</script>