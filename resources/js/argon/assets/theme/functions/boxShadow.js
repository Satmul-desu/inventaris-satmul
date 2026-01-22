/**
=========================================================
* Argon Dashboard 2 MUI - v3.0.1
=========================================================

* Product Page: https://www.creative-tim.com/product/argon-dashboard-material-ui
* Copyright 2023 Creative Tim (https://www.creative-tim.com)

Coded by www.creative-tim.com

 =========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
*/

import rgba from "./rgba";
import colors from "assets/theme/base/colors";

function boxShadow(shadow, color = colors.grey[400], opacity = 0.14) {
  const [x, y] = shadow;

  return `${x}px ${y}px ${opacity}px 0 ${rgba(color, opacity)}, ${x}px ${y}px ${opacity * 2}px 0 ${rgba(
    color,
    opacity
  )}`;
}

export default boxShadow;

