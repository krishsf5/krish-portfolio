/* --------------------------------------------------
   TECH STACK DRAG — persists sort_order via fetch
-------------------------------------------------- */

export default function initTechStackDrag() {

    const columns = document.querySelectorAll('.tech-list')

    if (!columns.length) return

    columns.forEach(column => {

        const sortable = new Sortable(column, {
            draggable: '.tech-card',
            mirror: { constrainDimensions: true },
            delay: 100,
        })

        sortable.on('sortable:stop', () => {

            // wait one tick for DOM to update
            requestAnimationFrame(() => {

                const ids = [...column.querySelectorAll('.tech-card')]
                    .map(card => card.dataset.skillId)
                    .filter(Boolean)

                if (!ids.length) return

                fetch('/dashboard/skills/reorder', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? '',
                    },
                    body: JSON.stringify({ ids }),
                })

            })

        })

    })

}
