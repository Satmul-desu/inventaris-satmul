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

// @mui material components
import Card from "@mui/material/Card";
import { styled } from "@mui/material/styles";

export default styled(Card)(({ theme, ownerState }) => {
  const { palette, boxShadows, functions, borders } = theme;
  const { color } = ownerState;

  const { white, gradients } = palette;
  const { card } = boxShadows;
  const { linearGradient } = functions;
  const { borderRadius } = borders;

  return {
    backgroundImage: gradients[color]
      ? `linear-gradient(81.62deg, ${gradients[color].main} 2.25%, ${gradients[color].state} 100.2%)`
      : gradients.primary.main,
    boxShadow: card,
    borderRadius: borderRadius.xl,
    overflow: "hidden",
  };
});