using System;
using System.Collections.Generic;
using System.Data;

namespace projetFoxmon
{
    public class RenardElectrique : Foxmon
    {
        public RenardElectrique(string nom)
        : base(
            nom,
            pv: 65,
            pvm: 65,
            lvl: 3,
            speed: 12,
            degats: 15,
            typeElementaire: "Électrique")
        {

        }
    }
}