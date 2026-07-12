namespace projetFoxmon
{
    public class RenardFeu : Foxmon
    {
        public RenardFeu(string nom)
        : base(
            nom,
            pv: 100,
            pvm: 100,
            lvl: 5,
            speed: 10,
            degats: 20,
            typeElementaire: "Feu"
            )
        {

        }
    }
}