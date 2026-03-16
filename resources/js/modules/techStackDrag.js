/* --------------------------------------------------
   TECH STACK DRAGGING
-------------------------------------------------- */

export default function initTechStackDrag() {

    const columns = document.querySelectorAll(".tech-list")

    if (!columns.length) return

    columns.forEach(column => {

        new Sortable(column, {

            draggable: ".tech-card",

            mirror: {
                constrainDimensions: true
            },

            plugins: [],

            delay: 100

        })

    })

}
