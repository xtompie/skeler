// import SandboxBootstrap from "./Boostrap/sandbox/Boostrap.vue"

// const sandboxes = {
//   SandboxBootstrap,
// }

// export default {
//   routes: [
//     ...Object.entries(sandboxes).forEach(e => {
//       return {
//         path: "/" + e[0],
//         component: e[1],
//       }
//     })
//   ],
// };

export default {
    routes: [
      {
        path: "/Bootstrap",
        component: () => import("./Bootstrap/sandbox/Bootstrap.vue"),
      },
    ],
  };

