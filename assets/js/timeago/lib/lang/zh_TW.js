"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.default = _default;

function _default(number, index) {
  return [['剛剛', '片刻後'], ['%s 秒前', '%s 秒後'], ['1 分鐘前', '1 分鐘後'], ['%s 分鐘前', '%s 分鐘後'], ['1 小時前', '1 小時後'], ['%s 小時前', '%s 小時後'], ['1 天前', '1 天後'], ['%s 天前', '%s 天後'], ['1 週前', '1 週後'], ['%s 週前', '%s 週後'], ['1 月前', '1 月後'], ['%s 月前', '%s 月後'], ['1 年前', '1 年後'], ['%s 年前', '%s 年後']][index];
}

module.exports = exports.default;