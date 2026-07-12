using System;
using System.Collections.Generic;
using System.Data;

namespace projetFoxmon
{
    public class RenardSol : Foxmon
    {
        public RenardSol(string nom)
        : base(
            nom,
            pv: 100,
            pvm: 100,
            lvl: 5,
            speed: 10,
            degats: 20,
            typeElementaire: "Sol")
        {

        }
    }
}