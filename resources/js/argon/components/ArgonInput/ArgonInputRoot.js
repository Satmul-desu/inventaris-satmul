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
import InputBase from "@mui/material/InputBase";
import { styled } from "@mui/material/styles";

export default styled(InputBase)(({ theme, ownerState }) => {
  const { palette, functions, borders } = theme;
  const { error, success: successState, size } = ownerState;

  const { grey, inputBorderColor, success: successColor } = palette;
  const { pxToRem } = functions;
  const { borderRadius } = borders;

  // styles for the input with size="small"
  const smallStyles = () => ({
    height: pxToRem(34),
    fontSize: pxToRem(12),
  });

  // styles for the input with size="large"
  const largeStyles = () => ({
    height: pxToRem(50),
    fontSize: pxToRem(16),
  });

  // styles for the input with error={true}
  const errorStyles = () => ({
    border: `1px solid ${error}`,
    "&:focus": {
      border: `1px solid ${error}`,
    },
  });

  // styles for the input with success={true}
  const successStyles = () => ({
    border: `1px solid ${successColor.main}`,
    "&:focus": {
      border: `1px solid ${successColor.main}`,
    },
  });

  return {
    borderRadius: borderRadius.md,
    padding: `${pxToRem(12)} ${pxToRem(16)}`,
    fontSize: pxToRem(14),
    fontWeight: 400,
    color: grey[700],
    backgroundColor: "#fff",
    border: `1px solid ${inputBorderColor}`,
    "&:focus": {
      border: `1px solid ${palette.primary.main}`,
    },
    ...(size === "small" && { ...smallStyles() }),
    ...(size === "large" && { ...largeStyles() }),
    ...(error && { ...errorStyles() }),
    ...(successState && { ...successStyles() }),
  };
});

