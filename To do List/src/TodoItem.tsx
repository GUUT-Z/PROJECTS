type Priority = "Urgente" | "Moyenne" | "Basse"

type Todo = {
  id: number
  text: string
  priority: Priority
}

type Props = {
  todo: Todo
  onDelete: () => void
  isSelected : boolean
   onToggleSelect : (id: number) => void
}

const TodoItem = ({ todo, onDelete, isSelected, onToggleSelect }: Props) => {
  return (
    <div className="p-3">
      <div className="flex justify-between items-center">
        <div className="flex items-center gap-2">
          <input type="checkbox" className="checkbox checkbox-primary checkbox-small"
          checked={isSelected}
          onChange={() => onToggleSelect(todo.id)}
          />
          <span className="text-md font-bold">{todo.text}</span>
          <span
            className={
              "badge badge-sm badge-soft " +
              (todo.priority === "Urgente"
                ? "badge-error"
                : todo.priority === "Moyenne"
                  ? "badge-warning"
                  : "badge-success")
            }
          >
            {todo.priority}
          </span>
        </div>

        <button
          type="button"
          onClick={onDelete}
          className="btn btn-ghost btn-error btn-soft btn-sm"
        >
          X
        </button>
      </div>
    </div>
  )
}

export default TodoItem